<?php
include __DIR__ . '/db_connect.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM Product_T WHERE Product_ID = ?");
    $stmt->bind_param("s", $product_id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();

// Redirect to main page
header("Location: f1.php");
exit();
?>
