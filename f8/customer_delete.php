<?php
include __DIR__ . '/db_connect.php';

if (isset($_GET['id'])) {
    $customer_id = $_GET['id'];

    // Prepare the DELETE query to remove the customer based on Customer_ID
    $stmt = $conn->prepare("DELETE FROM Customer_T WHERE Customer_ID = ?");
    $stmt->bind_param("s", $customer_id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();

// Redirect to the customer list page after deletion
header("Location: f8.php#customers");
exit();
?>
