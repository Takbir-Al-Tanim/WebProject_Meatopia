<?php
$mysqli = new mysqli("localhost", "root", "", "supply_chain");
if ($mysqli->connect_errno) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Retrieve form data
$warehouseName = $_POST['warehouseName'];
$location = $_POST['location'];
$coldCapacity = $_POST['coldCapacity'];
$currentInventory = $_POST['currentInventory'];
$meatType = $_POST['meatType'];
$deliveryId = $_POST['deliveryId'];
$deliveryDate = $_POST['deliveryDate'];
$logisticsPartner = $_POST['logisticsPartner'];
$coldChainCompliance = $_POST['coldChainCompliance'];

// Generate new Warehouse_ID (e.g., WH006)
$lastIDResult = $mysqli->query("SELECT MAX(Warehouse_ID) AS max_id FROM warehouse");
$lastID = $lastIDResult->fetch_assoc()['max_id'];
$newIdNum = intval(substr($lastID, 2)) + 1;
$newWarehouseId = "WH" . str_pad($newIdNum, 3, '0', STR_PAD_LEFT);

// Insert into warehouse table
$vendorID = $coldChainCompliance === "Yes" ? "VEND999" : "NULL"; // temp vendor logic
$vendorField = $coldChainCompliance === "Yes" ? "'$vendorID'" : "NULL";

$warehouseSQL = "
INSERT INTO warehouse (Warehouse_ID, Warehouse_Name, Location, Cold_Storage_Capacity, Current_Inventory_Level, Meat_Type_Stored, Vendor_ID)
VALUES ('$newWarehouseId', '$warehouseName', '$location', $coldCapacity, $currentInventory, '$meatType', $vendorField)
";

if (!$mysqli->query($warehouseSQL)) {
    die("Warehouse insert failed: " . $mysqli->error);
}

// Insert into delivery table
$deliverySQL = "
INSERT INTO delivery (Delivery_ID, Delivery_Date, Address, City, State, ZIP, Batch_ID, Warehouse_ID, Order_ID, Logistics_Partner)
VALUES ('$deliveryId', '$deliveryDate', 'Auto Generated Address', '$location', 'AutoState', '00000', 'BAT999', '$newWarehouseId', 'ORD999', '$logisticsPartner')
";

if (!$mysqli->query($deliverySQL)) {
    die("Delivery insert failed: " . $mysqli->error);
}

header("Location: f4.php");
exit();
?>
