<?php 
include __DIR__ . '/db_connect.php'; 

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']); // Sanitize the ID

    $sql = "DELETE FROM Nutrition_T WHERE `Nutrition_ID` = '$id'";  // TABLE AND COLUMN NAME CORRECTED
    if ($conn->query($sql) === TRUE) {
        echo '<div class="alert alert-success" role="alert">Record deleted successfully!</div>';
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    header("refresh:2; url=f3_view.php"); // Redirect after deletion  // UPDATED URL
} else {
    echo "Invalid request!";
}

$conn->close();

?>