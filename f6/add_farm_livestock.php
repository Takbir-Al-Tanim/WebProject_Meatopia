<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Livestock</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="text-center mb-4">Add Livestock Details</h2>

    <div class="card p-4 shadow-sm">
      <form action="f6_update_livestock.php" method="POST">
        <!-- Action hidden field to specify insert operation -->
        <input type="hidden" name="cattle_action" value="save">

        <div class="row mb-3">
          <div class="col-md-4">
            <label class="form-label">Cattle ID</label>
            <input type="text" class="form-control" name="cattleId" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Breed</label>
            <input type="text" class="form-control" name="breed" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Weight (kg)</label>
            <input type="number" step="0.01" class="form-control" name="weight" required>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label class="form-label">Age (months)</label>
            <input type="number" class="form-control" name="age" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Health Status</label>
            <input type="text" class="form-control" name="health" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Farm ID</label>
            <input type="text" class="form-control" name="farmId" required>
          </div>
        </div>

        <button type="submit" class="btn btn-success">Submit Livestock Info</button>
      </form>
    </div>
  </div>
</body>
</html>
