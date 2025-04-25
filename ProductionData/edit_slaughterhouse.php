<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $slaughterhouse_id = $_GET['id'];
    $sql = "SELECT * FROM slaughterhouse_t WHERE Slaughterhouse_ID = '$slaughterhouse_id'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $slaughterhouse = mysqli_fetch_assoc($result);
    } else {
        die("Slaughterhouse data not found.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Slaughterhouse</title>
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
    <h2 class="text-center">Edit Slaughterhouse Information</h2>
    <form method="POST" action="update_slaughterhouse.php">
        <input type="hidden" name="Slaughterhouse_ID" value="<?= htmlspecialchars($slaughterhouse['Slaughterhouse_ID'] ?? '') ?>">

        <div class="mb-4">
            <label for="name" class="form-label">Slaughterhouse Name</label>
            <input type="text" class="form-control" id="name" name="Name" value="<?= htmlspecialchars($slaughterhouse['Name'] ?? '') ?>" required>
        </div>

        <div class="mb-4">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="Location" value="<?= htmlspecialchars($slaughterhouse['Location'] ?? '') ?>" required>
        </div>

        <div class="mb-4">
            <label for="capacity" class="form-label">Capacity</label>
            <input type="number" class="form-control" id="capacity" name="Capacity" value="<?= htmlspecialchars($slaughterhouse['Capacity'] ?? '') ?>" required>
        </div>

        <div class="mb-4">
            <label for="equipment" class="form-label">Equipment</label>
            <input type="text" class="form-control" id="equipment" name="Equipment" value="<?= htmlspecialchars($slaughterhouse['Equipment'] ?? '') ?>" required>
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
