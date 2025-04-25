<?php
$mysqli = new mysqli("localhost", "root", "", "supply_chain");
if ($mysqli->connect_errno) {
    die("Connection failed: " . $mysqli->connect_error);
}

$id = $_GET['id'] ?? '';

$query = "
SELECT w.*, d.Delivery_ID, d.Delivery_Date, d.Logistics_Partner,
       CASE WHEN w.Vendor_ID IS NOT NULL THEN 'Yes' ELSE 'No' END AS Cold_Chain_Compliance
FROM warehouse w
LEFT JOIN delivery d ON d.Warehouse_ID = w.Warehouse_ID
WHERE w.Warehouse_ID = '$id'
";

$result = $mysqli->query($query);
if (!$result || $result->num_rows === 0) {
    die("Entry not found.");
}
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Supply Entry</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="text-center mb-4">Edit Supply Entry</h2>
    <form action="update_f4.php" method="POST" class="card p-4 shadow-sm">

      <input type="hidden" name="warehouseId" value="<?= $row['Warehouse_ID'] ?>">

      <h5 class="mb-3">Warehouse Info</h5>
      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Warehouse Name</label>
          <input type="text" class="form-control" name="warehouseName" value="<?= $row['Warehouse_Name'] ?>" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Location</label>
          <input type="text" class="form-control" name="location" value="<?= $row['Location'] ?>" required>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Cold Storage Capacity (kg)</label>
          <input type="number" class="form-control" name="coldCapacity" value="<?= $row['Cold_Storage_Capacity'] ?>" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Current Inventory Level (kg)</label>
          <input type="number" class="form-control" name="currentInventory" value="<?= $row['Current_Inventory_Level'] ?>" required>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Meat Type Stored</label>
        <input type="text" class="form-control" name="meatType" value="<?= $row['Meat_Type_Stored'] ?>" required>
      </div>

      <h5 class="mb-3">Delivery Info</h5>
      <input type="hidden" name="deliveryId" value="<?= $row['Delivery_ID'] ?>">
      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Delivery Date</label>
          <input type="date" class="form-control" name="deliveryDate" value="<?= $row['Delivery_Date'] ?>" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Logistics Partner</label>
          <input type="text" class="form-control" name="logisticsPartner" value="<?= $row['Logistics_Partner'] ?>" required>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Cold Chain Compliance</label>
        <select class="form-select" name="coldChainCompliance">
          <option value="Yes" <?= $row['Cold_Chain_Compliance'] === 'Yes' ? 'selected' : '' ?>>Yes</option>
          <option value="No" <?= $row['Cold_Chain_Compliance'] === 'No' ? 'selected' : '' ?>>No</option>
        </select>
      </div>

      <div class="text-end">
        <button type="submit" class="btn btn-success">Update Entry</button>
        <a href="f4.php" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
</body>
</html>
