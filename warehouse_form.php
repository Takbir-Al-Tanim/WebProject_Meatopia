<?php
include __DIR__ . '/db_connect.php';

$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $warehouseID = $_POST['warehouse_id'];
    $address = $_POST['address'];
    $location = $_POST['location'];
    $capacity = $_POST['capacity'];
    $inventory = $_POST['inventory'];
    $meatType = $_POST['meat_type'];

    $stmt = $conn->prepare("INSERT INTO Warehouse_T (Warehouse_ID, Address, Location, Cold_Storage_Capacity, Current_inventory_Level, Meat_Type_Stored)
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdis", $warehouseID, $address, $location, $capacity, $inventory, $meatType);

    if ($stmt->execute()) {
        header("Location: f4_read.php"); // Redirect after successful insert
        exit;
    } else {
        $error = "Error inserting warehouse entry: " . $conn->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Warehouse Entry</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="mb-4">Add Warehouse Entry</h2>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <div class="mb-3">
      <label for="warehouse_id" class="form-label">Warehouse ID</label>
      <input type="text" class="form-control" id="warehouse_id" name="warehouse_id" required>
    </div>
    <div class="mb-3">
      <label for="address" class="form-label">Address</label>
      <input type="text" class="form-control" id="address" name="address" required>
    </div>
    <div class="mb-3">
      <label for="location" class="form-label">Location</label>
      <input type="text" class="form-control" id="location" name="location" required>
    </div>
    <div class="mb-3">
      <label for="capacity" class="form-label">Cold Storage Capacity</label>
      <input type="number" class="form-control" id="capacity" name="capacity" step="0.01" required>
    </div>
    <div class="mb-3">
      <label for="inventory" class="form-label">Current Inventory Level</label>
      <input type="number" class="form-control" id="inventory" name="inventory" step="0.01" required>
    </div>
    <div class="mb-3">
      <label for="meat_type" class="form-label">Meat Type Stored</label>
      <input type="text" class="form-control" id="meat_type" name="meat_type" required>
    </div>
    <button type="submit" class="btn btn-success">Submit</button>
    <a href="f4_read.php" class="btn btn-secondary">Back to Dashboard</a>
  </form>
</div>

</body>
</html>
