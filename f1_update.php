<?php
include __DIR__ . '/db_connect.php';

$product = [
    'Product_ID' => '',
    'Meat_Type' => '',
    'Cut_Type' => '',
    'Country' => '',
    'Region' => '',
    'Seasonality' => '',
    'Certifications' => '',
    'Fat_Content' => '',
    'Grade' => '',
    'Cattle_ID' => ''
];

$edit_mode = false;
$success_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Product_ID = $_POST['Product_ID'];
    $Meat_Type = $_POST['Meat_Type'];
    $Cut_Type = $_POST['Cut_Type'];
    $Country = $_POST['Country'];
    $Region = $_POST['Region'];
    $Seasonality = $_POST['Seasonality'];
    $Certifications = $_POST['Certifications'];
    $Fat_Content = $_POST['Fat_Content'];
    $Grade = $_POST['Grade'];
    $Cattle_ID = $_POST['Cattle_ID'];

    if (!empty($Product_ID)) {
        // UPDATE
        $stmt = $conn->prepare("UPDATE Product_T SET Meat_Type=?, Cut_Type=?, Country=?, Region=?, Seasonality=?, Certifications=?, Fat_Content=?, Grade=?, Cattle_ID=? WHERE Product_ID=?");
        $stmt->bind_param("ssssssssss", $Meat_Type, $Cut_Type, $Country, $Region, $Seasonality, $Certifications, $Fat_Content, $Grade, $Cattle_ID, $Product_ID);
        $stmt->execute();
        $stmt->close();
        $success_message = "Product updated successfully.";
    } else {
        // INSERT - Generate unique ID
        do {
            $new_id = 'PRD' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
            $check = $conn->prepare("SELECT Product_ID FROM Product_T WHERE Product_ID = ?");
            $check->bind_param("s", $new_id);
            $check->execute();
            $check->store_result();
        } while ($check->num_rows > 0);
        $check->close();

        $stmt = $conn->prepare("INSERT INTO Product_T (Product_ID, Meat_Type, Cut_Type, Country, Region, Seasonality, Certifications, Fat_Content, Grade, Cattle_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $new_id, $Meat_Type, $Cut_Type, $Country, $Region, $Seasonality, $Certifications, $Fat_Content, $Grade, $Cattle_ID);
        $stmt->execute();
        $stmt->close();
        $success_message = "Product added successfully.";
    }
}

// Load product if editing
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $product_id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM Product_T WHERE Product_ID = ?");
    $stmt->bind_param("s", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $product = $row;
    }
    $stmt->close();
}

// Get cattle options
$cattle_options = '';
$cattle_result = $conn->query("SELECT Cattle_ID, Breed FROM Cattle_T");
while ($row = $cattle_result->fetch_assoc()) {
    $selected = ($row['Cattle_ID'] == $product['Cattle_ID']) ? 'selected' : '';
    $cattle_options .= "<option value='" . htmlspecialchars($row['Cattle_ID']) . "' $selected>" . htmlspecialchars($row['Breed']) . "</option>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $edit_mode ? 'Edit' : 'Add' ?> Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2><?= $edit_mode ? 'Edit' : 'Add' ?> Product</h2>

    <?php if ($success_message): ?>
        <div class="alert alert-success"><?= $success_message ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <input type="hidden" name="Product_ID" value="<?= htmlspecialchars($product['Product_ID']) ?>">

        <div class="mb-3">
            <label class="form-label">Meat Type</label>
            <input type="text" class="form-control" name="Meat_Type" value="<?= htmlspecialchars($product['Meat_Type']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Cut Type</label>
            <input type="text" class="form-control" name="Cut_Type" value="<?= htmlspecialchars($product['Cut_Type']) ?>">
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
            <select class="form-select" name="Cattle_ID" required>
                <option value="">Select Cattle</option>
                <?= $cattle_options ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a href="f1.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
<?php $conn->close(); ?>
