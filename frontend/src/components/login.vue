<template>
    <div>
        <h2>Login</h2>
        <input v-model="username" placeholder="Gebruikersnaam" />
        <input v-model="password" type="password" placeholder="Wachtwoord" />
        <button @click="login">Inloggen</button>
        <p v-if="error">{{ error }}</p>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return { username: "", password: "", error: "" };
    },
    methods: {
        async login() {
            try {
                const res = await axios.post("http://localhost:5000/api/auth/login", {
                    username: this.username,
                    password: this.password,
                });
                localStorage.setItem("token", res.data.token);
                this.$router.push("/dashboard");
            } catch (err) {
                this.error = "Fout bij inloggen";
            }
        },
    },
};
</script>
