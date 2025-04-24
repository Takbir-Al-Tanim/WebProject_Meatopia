<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    
    $sql = "DELETE FROM Product_T WHERE Product_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $product_id);
    
    if ($stmt->execute()) {
        header("Location: f1.php?delete_success=1");
    } else {
        header("Location: f1.php?delete_error=1");
    }
    $stmt->close();
} else {
    header("Location: f1.php");
}
$conn->close();
?>