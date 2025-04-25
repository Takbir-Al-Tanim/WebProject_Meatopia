<?php
include __DIR__ . '/db_connect.php';

if (isset($_GET['id'])) {
    $vendor_id = $_GET['id'];

    // Prepare the DELETE query to remove the vendor based on Vendor_ID
    $stmt = $conn->prepare("DELETE FROM Vendor_T WHERE Vendor_ID = ?");
    $stmt->bind_param("s", $vendor_id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();

// Redirect to the vendor list page after deletion
header("Location: f8.php#vendors");
exit();
?>
