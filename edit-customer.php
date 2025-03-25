<?php
/**
 * File: edit-customer.php
 * Description: Handles updating customer information in the database.
 * Author: Florian Groot
 * Email: floriangrootkb@gmail.com
 * Date Created: <2025-03-24>
 * Last Modified: <2025-03-25>

 * Notes:
 * - This script updates customer details via a POST request.
 * - If accessed via GET with an ID, it fetches the customer details for editing.
 * - Uses prepared statements to prevent SQL injection.
 */
?>

<?php
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $companyName = $_POST['company_name'];
    $contactPerson = $_POST['contact_person'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $lastContactDate = $_POST['last_contact_date'];
    $nextContactDate = $_POST['next_contact_date'];
    $notes = $_POST['notes'];
    
    try {
        $stmt = $pdo->prepare("
            UPDATE customers 
            SET company_name = ?, 
                contact_person = ?, 
                email = ?, 
                phone = ?, 
                address = ?, 
                last_contact_date = ?, 
                next_contact_date = ?, 
                notes = ?,
                updated_at = CURRENT_TIMESTAMP
            WHERE id = ?
        ");
        
        $stmt->execute([
            $companyName,
            $contactPerson,
            $email,
            $phone,
            $address,
            $lastContactDate,
            $nextContactDate,
            $notes,
            $id
        ]);
        
        header('Location: index.php?message=Customer updated successfully');
        exit();
    } catch (PDOException $e) {
        die("Error updating customer: " . $e->getMessage());
    }
} else if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM customers WHERE id = ?");
        $stmt->execute([$id]);
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$customer) {
            header('Location: index.php?error=Customer not found');
            exit();
        }
    } catch (PDOException $e) {
        die("Error fetching customer: " . $e->getMessage());
    }
} else {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Customer</h1>
        <form method="POST" action="edit-customer.php">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($customer['id']); ?>">
            
            <div class="form-group">
                <label for="company_name">Company Name:</label>
                <input type="text" id="company_name" name="company_name" 
                       value="<?php echo htmlspecialchars($customer['company_name']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="contact_person">Contact Person:</label>
                <input type="text" id="contact_person" name="contact_person" 
                       value="<?php echo htmlspecialchars($customer['contact_person']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" 
                       value="<?php echo htmlspecialchars($customer['email']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" 
                       value="<?php echo htmlspecialchars($customer['phone']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea id="address" name="address" required><?php echo htmlspecialchars($customer['address']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="last_contact_date">Last Contact Date:</label>
                <input type="date" id="last_contact_date" name="last_contact_date" 
                       value="<?php echo htmlspecialchars($customer['last_contact_date']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="next_contact_date">Next Contact Date:</label>
                <input type="date" id="next_contact_date" name="next_contact_date" 
                       value="<?php echo htmlspecialchars($customer['next_contact_date']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="notes">Notes:</label>
                <textarea id="notes" name="notes"><?php echo htmlspecialchars($customer['notes']); ?></textarea>
            </div>
            
            <div class="button-group">
                <button type="submit" class="btn btn-primary">Update Customer</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
