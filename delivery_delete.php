<?php
include __DIR__ . '/db_connect.php';

if (isset($_GET['delivery_id'])) {
    $delivery_id = $_GET['delivery_id'];

    $sql = "DELETE FROM Delivery_T WHERE Delivery_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $delivery_id);

    if ($stmt->execute()) {
        header("Location: f4_read.php");
        exit;
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
} else {
    echo "No Delivery_ID specified.";
}
