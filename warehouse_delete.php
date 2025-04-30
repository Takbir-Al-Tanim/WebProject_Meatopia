<?php
include __DIR__ . '/db_connect.php'; // Database connection file

if (isset($_GET['warehouse_id'])) {
    $warehouse_id = $_GET['warehouse_id'];

    // Prepare the SQL statement to delete the warehouse record
    $sql = "DELETE FROM Warehouse_T WHERE Warehouse_ID = ?";
    
    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $warehouse_id);  // "s" for string

    // Execute the query
    if ($stmt->execute()) {
        // Successfully deleted, redirect to the warehouse list page
        header('Location: f4_read.php');  // Redirect to the warehouse list page
        exit;
    } else {
        // If there's an error, display the error message
        echo "Error deleting record: " . $conn->error;
    }
} else {
    // If no warehouse_id is provided in the URL, display an error
    echo "No warehouse ID specified.";
}
?>
