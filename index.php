<?php
require_once 'config/database.php';
include 'includes/header.php';

$stmt = $pdo->query("SELECT * FROM customers ORDER BY company_name");
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h1>Customer Maintenance System</h1>
    <a href="add-customer.php" class="btn btn-primary">Add New Customer</a>
    
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Company Name</th>
                <th>Contact Person</th>
                <th>Email</th>
                <th>Last Contact</th>
                <th>Next Contact</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($customers as $customer): ?>
            <tr>
                <td><?= htmlspecialchars($customer['company_name']) ?></td>
                <td><?= htmlspecialchars($customer['contact_person']) ?></td>
                <td><?= htmlspecialchars($customer['email']) ?></td>
                <td><?= $customer['last_contact_date'] ?></td>
                <td><?= $customer['next_contact_date'] ?></td>
                <td>
                    <a href="view-customer.php?id=<?= $customer['id'] ?>" class="btn btn-info btn-sm">View</a>
                    <a href="edit-customer.php?id=<?= $customer['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete-customer.php?id=<?= $customer['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
