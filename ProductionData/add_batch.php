<?php
include 'db_connect.php';

function generateBatchID($conn) {
  $sql = "SELECT MAX(CAST(SUBSTRING(Batch_ID, 4) AS UNSIGNED)) AS max_id FROM batch_t";
  $result = $conn->query($sql);
  $num = ($result && $result->num_rows > 0) ? $result->fetch_assoc()['max_id'] + 1 : 1;
  return 'BAT' . str_pad($num, 3, '0', STR_PAD_LEFT);
}

$successMsg = $errorMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $batch_id = generateBatchID($conn);
  $production_date = $_POST["production_date"];
  $expiry_date = $_POST["expiry_date"];
  $quantity = $_POST["quantity"];
  $storage_location = $_POST["storage_location"];
  $product_id = $_POST["product_id"];

  // Check if the entered product_id exists in product_t
  $check = $conn->query("SELECT * FROM product_t WHERE Product_ID = '$product_id'");
  if ($check && $check->num_rows > 0) {
    $sql = "INSERT INTO batch_t (Batch_ID, Production_Date, Expiry_Date, Quantity, Storage_Location, Product_ID)
            VALUES ('$batch_id', '$production_date', '$expiry_date', '$quantity', '$storage_location', '$product_id')";

    if ($conn->query($sql) === TRUE) {
      $successMsg = "✅ Batch data added successfully!";
    } else {
      $errorMsg = "❌ Error inserting batch: " . $conn->error;
    }
  } else {
    $errorMsg = "❌ Error: The entered Product ID does not exist.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Add Batch</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4">Add Batch Data</h2>

  <?php if ($successMsg): ?>
    <div class="alert alert-success"><?= $successMsg ?></div>
  <?php elseif ($errorMsg): ?>
    <div class="alert alert-danger"><?= $errorMsg ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Production Date</label>
      <input type="date" name="production_date" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Expiry Date</label>
      <input type="date" name="expiry_date" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Quantity (kg)</label>
      <input type="number" name="quantity" step="0.01" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Storage Location</label>
      <input type="text" name="storage_location" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Product ID</label>
      <input type="text" name="product_id" class="form-control" placeholder="Enter Product ID" required>
      <small class="text-muted">Enter the Product ID manually (e.g., PRD001)</small>
    </div>
    <button type="submit" class="btn btn-success">Submit</button>
    <a href="index.html" class="btn btn-secondary">Back</a>
  </form>
</div>
</body>
</html>
