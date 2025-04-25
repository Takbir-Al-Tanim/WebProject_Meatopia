<?php
$mysqli = new mysqli("localhost", "root", "", "supply_chain");
if ($mysqli->connect_errno) {
    die("Connection failed: " . $mysqli->connect_error);
}

$warehouseId = $_POST['warehouseId'];
$warehouseName = $_POST['warehouseName'];
$location = $_POST['location'];
$coldCapacity = $_POST['coldCapacity'];
$currentInventory = $_POST['currentInventory'];
$meatType = $_POST['meatType'];

$deliveryId = $_POST['deliveryId'];
$deliveryDate = $_POST['deliveryDate'];
$logisticsPartner = $_POST['logisticsPartner'];
$coldChainCompliance = $_POST['coldChainCompliance'];

// Update warehouse
$updateWarehouse = "
    UPDATE warehouse SET 
        Warehouse_Name = ?, 
        Location = ?, 
        Cold_Storage_Capacity = ?, 
        Current_Inventory_Level = ?, 
        Meat_Type_Stored = ? 
    WHERE Warehouse_ID = ?
";
$stmt1 = $mysqli->prepare($updateWarehouse);
$stmt1->bind_param("ssddss", $warehouseName, $location, $coldCapacity, $currentInventory, $meatType, $warehouseId);
$stmt1->execute();

// Update delivery
$updateDelivery = "
    UPDATE delivery SET 
        Delivery_Date = ?, 
        Logistics_Partner = ? 
    WHERE Delivery_ID = ?
";
$stmt2 = $mysqli->prepare($updateDelivery);
$stmt2->bind_param("sss", $deliveryDate, $logisticsPartner, $deliveryId);
$stmt2->execute();

$stmt1->close();
$stmt2->close();
$mysqli->close();

header("Location: f4.php");
exit();
