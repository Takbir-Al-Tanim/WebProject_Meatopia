<?php
include __DIR__ . '/db_connect.php';

if (!isset($_GET['cattle_id'])) {
    die("Cattle ID not specified.");
}

$cattleId = $_GET['cattle_id'];

// Fetch the cattle data
$stmt = $conn->prepare("SELECT * FROM Cattle_T WHERE Cattle_ID = ?");
$stmt->bind_param("s", $cattleId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("No cattle found with the provided ID.");
}

$row = $result->fetch_assoc();

// Close connection early to reduce open connections
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Livestock</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="text-center mb-4">Edit Livestock Details</h2>

    <div class="card p-4 shadow-sm">
      <form action="f6_update_livestock.php" method="POST">
        <input type="hidden" name="cattle_action" value="update">
        <input type="hidden" name="original_cattle_id" value="<?php echo htmlspecialchars($row['Cattle_ID']); ?>">

        <div class="row mb-3">
          <div class="col-md-4">
            <label class="form-label">Cattle ID</label>
            <input type="text" class="form-control" name="cattleId" value="<?php echo htmlspecialchars($row['Cattle_ID']); ?>" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Breed</label>
            <input type="text" class="form-control" name="breed" value="<?php echo htmlspecialchars($row['Breed']); ?>" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Weight (kg)</label>
            <input type="number" step="0.01" class="form-control" name="weight" value="<?php echo htmlspecialchars($row['Weight']); ?>" required>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label class="form-label">Age (months)</label>
            <input type="number" class="form-control" name="age" value="<?php echo htmlspecialchars($row['Age']); ?>" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Health Status</label>
            <input type="text" class="form-control" name="health" value="<?php echo htmlspecialchars($row['Health']); ?>" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Farm ID</label>
            <input type="text" class="form-control" name="farmId" value="<?php echo htmlspecialchars($row['Farm_ID']); ?>" required>
          </div>
        </div>

        <button type="submit" class="btn btn-warning">Update Livestock Info</button>
      </form>
    </div>
  </div>
</body>
</html>
