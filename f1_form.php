<?php 
include __DIR__ . '/db_connect.php';  // Database connection

$product = [
    'Product_ID' => '',
    'Meat_Type' => '',
    'Country' => '',
    'Region' => '',
    'Seasonality' => '',
    'Certifications' => '',
    'Fat_Content' => '',
    'Grade' => '',
    'Cattle_ID' => ''
];

// Check if an edit request exists
if (isset($_GET['edit'])) {
    $product_id = $_GET['edit'];
    
    // Fetch existing product data
    $stmt = $conn->prepare("SELECT * FROM Product_T WHERE Product_ID = ?");
    $stmt->bind_param("s", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $product = $row;
    }
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form submission for saving the data
    $Product_ID = $_POST['Product_ID'];
    $Meat_Type = $_POST['Meat_Type'];
    $Country = $_POST['Country'];
    $Region = $_POST['Region'];
    $Seasonality = $_POST['Seasonality'];
    $Certifications = $_POST['Certifications'];
    $Fat_Content = $_POST['Fat_Content'];
    $Grade = $_POST['Grade'];
    $Cattle_ID = $_POST['Cattle_ID'];

    // Update the product in the database
    $stmt = $conn->prepare("UPDATE Product_T SET Meat_Type=?, Country=?, Region=?, Seasonality=?, Certifications=?, Fat_Content=?, Grade=?, Cattle_ID=? WHERE Product_ID=?");
    $stmt->bind_param("sssssssss", $Meat_Type, $Country, $Region, $Seasonality, $Certifications, $Fat_Content, $Grade, $Cattle_ID, $Product_ID);
    $stmt->execute();
    $stmt->close();

    header("Location: f1.php");  // Redirect back to the table page after saving
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Edit Product</h2>

    <form method="POST">
        <input type="hidden" name="Product_ID" value="<?= htmlspecialchars($product['Product_ID']) ?>">

        <div class="mb-3">
            <label class="form-label">Meat Type</label>
            <input type="text" class="form-control" name="Meat_Type" value="<?= htmlspecialchars($product['Meat_Type']) ?>" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Country</label>
                <input type="text" class="form-control" name="Country" value="<?= htmlspecialchars($product['Country']) ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Region</label>
                <input type="text" class="form-control" name="Region" value="<?= htmlspecialchars($product['Region']) ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Seasonality</label>
            <input type="text" class="form-control" name="Seasonality" value="<?= htmlspecialchars($product['Seasonality']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Certifications</label>
            <input type="text" class="form-control" name="Certifications" value="<?= htmlspecialchars($product['Certifications']) ?>" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Fat Content</label>
                <input type="text" class="form-control" name="Fat_Content" value="<?= htmlspecialchars($product['Fat_Content']) ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Grade</label>
                <input type="text" class="form-control" name="Grade" value="<?= htmlspecialchars($product['Grade']) ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Cattle Source</label>
            <input type="text" class="form-control" name="Cattle_ID" value="<?= htmlspecialchars($product['Cattle_ID']) ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="f1.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
