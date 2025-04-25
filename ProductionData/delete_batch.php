<?php
include('db_connect.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // First delete dependent delivery records
    $stmt1 = $conn->prepare("DELETE FROM delivery_t WHERE Batch_ID=?");
    $stmt1->bind_param("s", $id);
    $stmt1->execute();

    // Now delete from batch_t
    $stmt2 = $conn->prepare("DELETE FROM batch_t WHERE Batch_ID=?");
    $stmt2->bind_param("s", $id);

    if ($stmt2->execute()) {
        echo "Batch and related deliveries deleted successfully!";
    } else {
        echo "Error deleting batch: " . $conn->error;
    }
}
?>
