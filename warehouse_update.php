<?php
include __DIR__ . '/db_connect.php';

if (!isset($_GET['warehouse_id'])) {
    die("Warehouse ID not specified.");
}

$warehouseId = $_GET['warehouse_id'];

// Fetch the current data for the warehouse
$stmt = $conn->prepare("SELECT Warehouse_ID, Address, Location, Cold_Storage_Capacity, Current_inventory_Level, Meat_Type_Stored FROM Warehouse_T WHERE Warehouse_ID = ?");
$stmt->bind_param("s", $warehouseId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("No warehouse found with the provided ID.");
}

$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $address = $_POST['address'];
    $location = $_POST['location'];
    $capacity = $_POST['capacity'];
    $inventory = $_POST['inventory'];
    $meatType = $_POST['meat_type'];

    // Update warehouse details
    $updateStmt = $conn->prepare("UPDATE Warehouse_T SET Address = ?, Location = ?, Cold_Storage_Capacity = ?, Current_inventory_Level = ?, Meat_Type_Stored = ? WHERE Warehouse_ID = ?");
    $updateStmt->bind_param("ssddss", $address, $location, $capacity, $inventory, $meatType, $warehouseId);

    if ($updateStmt->execute()) {
        header("Location: f4_read.php"); // Redirect to the list of warehouses after successful update
        exit;
    } else {
        $error = "Error updating warehouse entry: " . $conn->error;
    }

    $updateStmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Update Warehouse Entry</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="mb-4">Update Warehouse Entry</h2>

  <?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <div class="mb-3">
      <label for="warehouse_id" class="form-label">Warehouse ID</label>
      <input type="text" class="form-control" id="warehouse_id" name="warehouse_id" value="<?= htmlspecialchars($row['Warehouse_ID']) ?>" disabled>
    </div>
    <div class="mb-3">
      <label for="address" class="form-label">Address</label>
      <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($row['Address']) ?>" required>
    </div>
    <div class="mb-3">
      <label for="location" class="form-label">Location</label>
      <input type="text" class="form-control" id="location" name="location" value="<?= htmlspecialchars($row['Location']) ?>" required>
    </div>
    <div class="mb-3">
      <label for="capacity" class="form-label">Cold Storage Capacity</label>
      <input type="number" class="form-control" id="capacity" name="capacity" value="<?= htmlspecialchars($row['Cold_Storage_Capacity']) ?>" step="0.01" required>
    </div>
    <div class="mb-3">
      <label for="inventory" class="form-label">Current Inventory Level</label>
      <input type="number" class="form-control" id="inventory" name="inventory" value="<?= htmlspecialchars($row['Current_inventory_Level']) ?>" step="0.01" required>
    </div>
    <div class="mb-3">
      <label for="meat_type" class="form-label">Meat Type Stored</label>
      <input type="text" class="form-control" id="meat_type" name="meat_type" value="<?= htmlspecialchars($row['Meat_Type_Stored']) ?>" required>
    </div>
    <button type="submit" class="btn btn-success">Update Warehouse</button>
    <a href="f4_read.php" class="btn btn-secondary">Back to Dashboard</a>
  </form>
</div>

</body>
</html>
