<?php
require __DIR__ . '/db_connect.php';

$test_query = "SELECT 1";
if ($conn->query($test_query)) {
    echo "SUCCESS: Database connection working!";
} else {
    echo "ERROR: " . $conn->error;
}
$conn->close();
?>