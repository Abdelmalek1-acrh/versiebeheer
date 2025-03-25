<?php
/**
 * File: view-customer.php
 * Description: Displays detailed information about a specific customer.
 * Author: Florian Groot
 * Date Created: <2025-03-24>
 * Last Modified: <2025-03-25>
 * Notes:
 * - Retrieves customer details based on the provided ID.
 * - Formats timestamps for readability.
 * - Provides options to edit or delete the customer.
 */
?>

<?php
require_once 'database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        $stmt = $pdo->prepare("
            SELECT *, 
                DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s') as formatted_created_at,
                DATE_FORMAT(updated_at, '%Y-%m-%d %H:%i:%s') as formatted_updated_at
            FROM customers 
            WHERE id = ?
        ");
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

require_once 'header.php';
?>

<div class="container">
    <div class="customer-details">
        <h1><?php echo htmlspecialchars($customer['company_name']); ?></h1>
        
        <div class="detail-grid">
            <div class="detail-item">
                <h3>Contact Information</h3>
                <p><strong>Contact Person:</strong> <?php echo htmlspecialchars($customer['contact_person']); ?></p>
                <p><strong>Email:</strong> <a href="mailto:<?php echo htmlspecialchars($customer['email']); ?>"><?php echo htmlspecialchars($customer['email']); ?></a></p>
                <p><strong>Phone:</strong> <a href="tel:<?php echo htmlspecialchars($customer['phone']); ?>"><?php echo htmlspecialchars($customer['phone']); ?></a></p>
            </div>
            
            <div class="detail-item">
                <h3>Address</h3>
                <p><?php echo nl2br(htmlspecialchars($customer['address'])); ?></p>
            </div>
            
            <div class="detail-item">
                <h3>Contact Dates</h3>
                <p><strong>Last Contact:</strong> <?php echo htmlspecialchars($customer['last_contact_date']); ?></p>
                <p><strong>Next Contact:</strong> <?php echo htmlspecialchars($customer['next_contact_date']); ?></p>
            </div>
            
            <div class="detail-item">
                <h3>Notes</h3>
                <p><?php echo nl2br(htmlspecialchars($customer['notes'])); ?></p>
            </div>
        </div>
        
        <div class="metadata">
            <p><small>Created: <?php echo htmlspecialchars($customer['formatted_created_at']); ?></small></p>
            <p><small>Last Updated: <?php echo htmlspecialchars($customer['formatted_updated_at']); ?></small></p>
        </div>
        
        <div class="button-group">
            <a href="edit-customer.php?id=<?php echo htmlspecialchars($customer['id']); ?>" class="btn btn-primary">Edit Customer</a>
            <a href="delete-customer.php?id=<?php echo htmlspecialchars($customer['id']); ?>" class="btn btn-danger">Delete Customer</a>
            <a href="index.php" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
