<?php
/**
 * File: Database.php
 * Description: Connects to the database and catches possible errors in the connection
 * Author: Florian Groot
 * Date Created: <2025-03-24>
 * Last Modified: <2025-03-25>
 **/
?>
<?php
define('DB_HOST', 'localhost');
define('DB_USER', '');
define('DB_PASS', '');
define('DB_NAME', 'customer_maintenance');

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
