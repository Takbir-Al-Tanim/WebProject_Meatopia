<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $batch_id = $_GET['id'];
    $sql = "SELECT * FROM batch_t WHERE Batch_ID = '$batch_id'";
    $result = mysqli_query($conn, $sql);
    $batch = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Batch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        .form-control, .btn {
            border-radius: 5px;
        }
        .form-label {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Edit Batch Information</h2>
    <form method="POST" action="update_batch.php">
        <input type="hidden" name="Batch_ID" value="<?= $batch['Batch_ID'] ?>">

        <div class="mb-4">
            <label for="productionDate" class="form-label">Production Date</label>
            <input type="date" class="form-control" id="productionDate" name="Production_Date" value="<?= $batch['Production_Date'] ?>" required>
        </div>

        <div class="mb-4">
            <label for="expiryDate" class="form-label">Expiry Date</label>
            <input type="date" class="form-control" id="expiryDate" name="Expiry_Date" value="<?= $batch['Expiry_Date'] ?>" required>
        </div>

        <div class="mb-4">
            <label for="quantity" class="form-label">Quantity (kg)</label>
            <input type="number" class="form-control" id="quantity" name="Quantity" value="<?= $batch['Quantity'] ?>" step="0.01" required>
        </div>

        <div class="mb-4">
            <label for="storageLocation" class="form-label">Storage Location</label>
            <input type="text" class="form-control" id="storageLocation" name="Storage_Location" value="<?= $batch['Storage_Location'] ?>" required>
        </div>

        <div class="mb-4">
            <label for="productID" class="form-label">Product ID</label>
            <input type="text" class="form-control" id="productID" name="Product_ID" value="<?= $batch['Product_ID'] ?>" required>
        </div>

        <div class="d-flex justify-content-between">
            <a href="index.html" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
