<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $livestock_id = $_GET['id'];
    $sql = "SELECT * FROM livestock_t WHERE Livestock_ID = '$livestock_id'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $livestock = mysqli_fetch_assoc($result);
    } else {
        die("Livestock data not found.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Livestock</title>
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
    <h2 class="text-center">Edit Livestock Information</h2>
    <form method="POST" action="update_livestock.php">
        <input type="hidden" name="Livestock_ID" value="<?= htmlspecialchars($livestock['Livestock_ID'] ?? '') ?>">

        <div class="mb-4">
            <label for="animalType" class="form-label">Animal Type</label>
            <input type="text" class="form-control" id="animalType" name="Animal_Type" value="<?= htmlspecialchars($livestock['Animal_Type'] ?? '') ?>" required>
        </div>

        <div class="mb-4">
            <label for="count" class="form-label">Count</label>
            <input type="number" class="form-control" id="count" name="Count" value="<?= htmlspecialchars($livestock['Count'] ?? '') ?>" required>
        </div>

        <div class="mb-4">
            <label for="region" class="form-label">Region</label>
            <input type="text" class="form-control" id="region" name="Region" value="<?= htmlspecialchars($livestock['Region'] ?? '') ?>" required>
        </div>

        <div class="mb-4">
            <label for="cost" class="form-label">Cost</label>
            <input type="number" class="form-control" id="cost" name="Cost" value="<?= htmlspecialchars($livestock['Cost'] ?? '') ?>" step="0.01" required>
        </div>

        <div class="mb-4">
            <label for="year" class="form-label">Year</label>
            <input type="number" class="form-control" id="year" name="Year" value="<?= htmlspecialchars($livestock['Year'] ?? '') ?>" required>
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
