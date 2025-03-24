<?php
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    
    try {
        // Begin transaction
        $pdo->beginTransaction();
        
        // Delete customer
        $stmt = $pdo->prepare("DELETE FROM customers WHERE id = ?");
        $stmt->execute([$id]);
        
        // Commit transaction
        $pdo->commit();
        
        header('Location: index.php?message=Customer deleted successfully');
        exit();
    } catch (PDOException $e) {
        // Rollback transaction on error
        $pdo->rollBack();
        die("Error deleting customer: " . $e->getMessage());
    }
} else if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        $stmt = $pdo->prepare("SELECT company_name FROM customers WHERE id = ?");
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
    <title>Delete Customer</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Delete Customer</h1>
        <div class="confirmation-box">
            <p>Are you sure you want to delete the customer "<?php echo htmlspecialchars($customer['company_name']); ?>"?</p>
            <p class="warning">This action cannot be undone!</p>
            
            <form method="POST" action="delete-customer.php">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                
                <div class="button-group">
                    <button type="submit" class="btn btn-danger">Delete Customer</button>
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
