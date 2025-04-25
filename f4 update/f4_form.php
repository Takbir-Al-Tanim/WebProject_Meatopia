<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Supply Entry</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="text-center mb-4">Add New Supply Entry</h2>
    <form action="insert_f4.php" method="POST" class="card p-4 shadow-sm">

      <h5 class="mb-3">Warehouse Info</h5>
      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Warehouse ID</label>
          <input type="text" class="form-control" name="warehouseId" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Location</label>
          <input type="text" class="form-control" name="location" required>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Cold Storage Capacity (kg)</label>
          <input type="number" class="form-control" name="coldCapacity" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Current Inventory Level (kg)</label>
          <input type="number" class="form-control" name="currentInventory" required>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Meat Type Stored</label>
        <input type="text" class="form-control" name="meatType" required>
      </div>

      <h5 class="mb-3">Delivery Info</h5>
      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Delivery ID</label>
          <input type="text" class="form-control" name="deliveryId" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Delivery Date</label>
          <input type="date" class="form-control" name="deliveryDate" required>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Logistics Partner</label>
          <input type="text" class="form-control" name="logisticsPartner" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Cold Chain Compliance</label>
          <select class="form-select" name="coldChainCompliance">
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </div>
      </div>

      <div class="text-end">
        <button type="submit" class="btn btn-success">Submit Entry</button>
        <a href="f4.php" class="btn btn-secondary">Back</a>
      </div>
    </form>
  </div>
</body>
</html>
