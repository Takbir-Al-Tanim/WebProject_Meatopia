<?php
include 'db_connect.php';

// Function to generate a new Livestock ID
function generateLivestockID($conn) {
    $sql = "SELECT MAX(CAST(SUBSTRING(livestock_id, 4) AS UNSIGNED)) AS max_id FROM livestock_t";
    $result = $conn->query($sql);
    // Checking if there are results and calculating the next ID
    $num = ($result && $result->num_rows > 0) ? $result->fetch_assoc()['max_id'] + 1 : 1;
    return 'LIV' . str_pad($num, 4, '0', STR_PAD_LEFT);
}

$successMsg = $errorMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form input handling
    $id = generateLivestockID($conn);
    $year = $_POST["year"];
    $animal_type = $_POST["animal_type"];
    $count = $_POST["animal_count"];
    $region = $_POST["region"];
    $cost = $_POST["Production_Cost_Per_Animal"];

    // SQL query to insert the data into the table
    $sql = "INSERT INTO livestock_t (livestock_id, year, animal_type, animal_count, region, Production_Cost_Per_Animal)
            VALUES ('$id', '$year', '$animal_type', '$count', '$region', '$cost')";

    if ($conn->query($sql) === TRUE) {
        $successMsg = "✅ Livestock data added successfully!";
    } else {
        $errorMsg = "❌ Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Add Livestock</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4">Add Livestock Data</h2>

  <!-- Displaying success or error message -->
  <?php if ($successMsg): ?>
    <div class="alert alert-success"><?= $successMsg ?></div>
  <?php elseif ($errorMsg): ?>
    <div class="alert alert-danger"><?= $errorMsg ?></div>
  <?php endif; ?>

  <!-- Livestock form -->
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Year</label>
      <input class="form-control" name="year" type="number" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Animal Type</label>
      <input class="form-control" name="animal_type" type="text" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Animal Count</label>
      <input class="form-control" name="animal_count" type="number" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Region</label>
      <input class="form-control" name="region" type="text" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Production Cost Per Animal</label>
      <input class="form-control" name="Production_Cost_Per_Animal" type="number" step="0.01" required>
    </div>
    <button type="submit" class="btn btn-success">Submit</button>
    <a href="index.html" class="btn btn-secondary">Back</a>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
