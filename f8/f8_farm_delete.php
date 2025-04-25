<?php
include __DIR__ . '/db_connect.php';

if (isset($_GET['id'])) {
    $vendor_id = $_GET['id'];

    // Step 1: Delete related records in warehouse_t that reference the vendor
    $stmt = $conn->prepare("DELETE FROM warehouse_t WHERE Wholesaler_Vendor_ID = ?");
    $stmt->bind_param("s", $vendor_id);
    $stmt->execute();
    $stmt->close();

    // Step 2: Now, delete the vendor from Vendor_T
    $stmt = $conn->prepare("DELETE FROM Vendor_T WHERE Vendor_ID = ?");
    $stmt->bind_param("s", $vendor_id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();

// Redirect back to the vendors page
header("Location: f8.php#vendors");
exit();
?>
