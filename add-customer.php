<?php
require_once 'config/database.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare("
            INSERT INTO customers (
                company_name, contact_person, email, phone, 
                address, last_contact_date, next_contact_date, notes
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $_POST['company_name'],
            $_POST['contact_person'],
            $_POST['email'],
            $_POST['phone'],
            $_POST['address'],
            $_POST['last_contact_date'],
            $_POST['next_contact_date'],
            $_POST['notes']
        ]);
        
        header('Location: index.php');
        exit;
    } catch(PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<div class="container">
    <h1>Add New Customer</h1>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="form-group">
            <label>Company Name</label>
            <input type="text" name="company_name" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Contact Person</label>
            <input type="text" name="contact_person" class="form-control">
        </div>
        
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Phone</label>
            <input type="tel" name="phone" class="form-control">
        </div>
        
        <div class="form-group">
            <label>Address</label>
            <textarea name="address" class="form-control"></textarea>
        </div>
        
        <div class="form-group">
            <label>Last Contact Date</label>
            <input type="date" name="last_contact_date" class="form-control">
        </div>
        
        <div class="form-group">
            <label>Next Contact Date</label>
            <input type="date" name="next_contact_date" class="form-control">
        </div>
        
        <div class="form-group">
            <label>Notes</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Add Customer</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
