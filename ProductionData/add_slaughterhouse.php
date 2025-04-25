<?php
include 'db_connect.php';

$successMsg = $errorMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $address = $_POST["address"];
  $capacity = $_POST["capacity"];
  $date = $_POST["date"];
  $quantity = $_POST["quantity"];
  $meat_type = $_POST["meat_type"];

  $sql = "INSERT INTO slaughterhouse_t (
            Slaughterhouse_Name, Address, Slaughter_Capacity, 
            Slaughter_Date, Quantity_Slaughtered, Slaughtered_Meat_Type
          ) VALUES (
            '$name', '$address', '$capacity', '$date', '$quantity', '$meat_type'
          )";

  if ($conn->query($sql) === TRUE) {
    $successMsg = "✅ Slaughterhouse data added successfully!";
  } else {
    $errorMsg = "❌ Error: " . $conn->error;
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Add Slaughterhouse</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4">Add Slaughterhouse Data</h2>

  <?php if ($successMsg): ?>
    <div class="alert alert-success"><?= $successMsg ?></div>
  <?php elseif ($errorMsg): ?>
    <div class="alert alert-danger"><?= $errorMsg ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Slaughterhouse Name</label>
      <input class="form-control" name="name" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Address</label>
      <input class="form-control" name="address" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Slaughter Capacity</label>
      <input class="form-control" type="number" name="capacity" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Slaughter Date</label>
      <input class="form-control" type="date" name="date" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Quantity Slaughtered</label>
      <input class="form-control" type="number" name="quantity" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Slaughtered Meat Type</label>
      <input class="form-control" name="meat_type" required>
    </div>

    <button type="submit" class="btn btn-success">Submit</button>
    <a href="index.html" class="btn btn-secondary">Back</a>
  </form>
</div>
</body>
</html>
