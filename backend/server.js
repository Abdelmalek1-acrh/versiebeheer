const express = require("express");
const mysql = require("mysql2");
const cors = require("cors");
const bcrypt = require("bcryptjs");
const jwt = require("jsonwebtoken");
require("dotenv").config();

const app = express();
app.use(express.json());
app.use(cors());

const db = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "versiebeheer",
});

db.connect(err => {
    if (err) throw err;
    console.log("✅ Database verbonden");
});

app.post("/api/auth/login", (req, res) => {
    const { username, password } = req.body;
    db.query("SELECT * FROM users WHERE username = ?", [username], (err, results) => {
        if (err) return res.status(500).json(err);
        if (results.length === 0) return res.status(401).json({ msg: "Ongeldige inloggegevens" });

        const user = results[0];
        bcrypt.compare(password, user.password, (err, isMatch) => {
            if (!isMatch) return res.status(401).json({ msg: "Ongeldige inloggegevens" });

            const token = jwt.sign({ id: user.id, role: user.role }, "secretkey", { expiresIn: "1h" });
            res.json({ token, role: user.role });
        });
    });
});

// 📋 Haal alle klanten op (admin-only)
app.get("/api/admin/customers", (req, res) => {
    db.query("SELECT * FROM customers", (err, results) => {
        if (err) return res.status(500).json(err);
        res.json(results);
    });
});

// 🔍 Haal klantonderhoud op
app.get("/api/user/maintenance/:id", (req, res) => {
    const { id } = req.params;
    db.query("SELECT * FROM maintenance WHERE customer_id = ?", [id], (err, results) => {
        if (err) return res.status(500).json(err);
        res.json(results);
    });
});

// 🆕 Voeg onderhoud toe
app.post("/api/maintenance", (req, res) => {
    const { customer_id, description } = req.body;
    db.query("INSERT INTO maintenance (customer_id, description) VALUES (?, ?)", [customer_id, description], (err) => {
        if (err) return res.status(500).json(err);
        res.json({ msg: "Onderhoud aangemaakt" });
    });
});

app.listen(5000, () => console.log("🚀 Server draait op poort 5000"));
