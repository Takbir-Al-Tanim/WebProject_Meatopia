<?php
$mysqli = new mysqli("localhost", "root", "", "supply_chain");
if ($mysqli->connect_errno) {
    die("Connection failed: " . $mysqli->connect_error);
}

$warehouseId = $_GET['id']; // expecting warehouse ID
$deliveryId = $_GET['delivery']; // expecting delivery ID

// First delete the delivery record
if (!empty($deliveryId)) {
    $stmt1 = $mysqli->prepare("DELETE FROM delivery WHERE Delivery_ID = ?");
    $stmt1->bind_param("s", $deliveryId);
    $stmt1->execute();
    $stmt1->close();
}

// Then delete the warehouse record
if (!empty($warehouseId)) {
    $stmt2 = $mysqli->prepare("DELETE FROM warehouse WHERE Warehouse_ID = ?");
    $stmt2->bind_param("s", $warehouseId);
    $stmt2->execute();
    $stmt2->close();
}

$mysqli->close();

header("Location: f4.php");
exit();
