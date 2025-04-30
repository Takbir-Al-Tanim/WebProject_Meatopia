<?php
include __DIR__ . '/db_connect.php';

if (!isset($_GET['cattle_id'])) {
    die("Cattle ID not provided.");
}

$cattleId = $_GET['cattle_id'];

// Prepare and execute the delete query
$stmt = $conn->prepare("DELETE FROM Cattle_T WHERE Cattle_ID = ?");
$stmt->bind_param("s", $cattleId);

if ($stmt->execute()) {
    header("Location: f6_read.php?msg=Cattle record deleted successfully");
    exit();
} else {
    echo "Delete Error: " . $stmt->error;
}

$conn->close();
?>
