<?php
include __DIR__ . '/db_connect.php';

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // First, check if the row exists
    $stmt = $conn->prepare("SELECT COUNT(*) FROM Order_T WHERE Order_ID = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->bind_result($row_count);
    $stmt->fetch();
    $stmt->close();

    // If row exists, proceed with deletion
    if ($row_count > 0) {
        $stmt = $conn->prepare("DELETE FROM Order_T WHERE Order_ID = ?");
        $stmt->bind_param("i", $order_id); // "i" for integer type
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();

// Redirect back to the order dashboard after deletion
header("Location: read.php");
exit();
?>
