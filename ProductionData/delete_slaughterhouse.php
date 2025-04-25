<?php
include('db_connect.php');

if (isset($_GET['name']) && isset($_GET['address'])) {
    $name = $_GET['name'];
    $address = $_GET['address'];
    $query = "DELETE FROM slaughterhouse_t WHERE Slaughterhouse_Name=? AND Address=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $name, $address);

    if ($stmt->execute()) {
        echo "Record deleted!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
