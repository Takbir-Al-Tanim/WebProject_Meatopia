<?php
include __DIR__ . '/db_connect.php';

$vendorData = [
    'Vendor_ID' => '',
    'Vendor_Type' => '',
    'Name' => '',
    'Street' => '',
    'City' => '',
    'State' => '',
    'Meat_Type_Sold' => '',
    'Contact_info' => '',
    'Email' => ''
];

$editMode = false;

if (isset($_GET['edit'])) {
    $editMode = true;
    $vendorId = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM Vendor_T WHERE Vendor_ID = ?");
    $stmt->bind_param("s", $vendorId);
    $stmt->execute();
    $result = $stmt->get_result();
    $vendorData = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $editMode ? 'Edit Vendor' : 'Add New Vendor'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-footer {
            display: flex;
            justify-content: start;
            gap: 15px;
            margin-top: 30px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <h2 class="text-center mb-4"><?php echo $editMode ? 'Edit Vendor Information' : 'Add New Vendor'; ?></h2>

        <form action="vendor_create.php" method="POST" class="card p-4 shadow-sm">
            <input type="hidden" name="editMode" value="<?php echo $editMode ? '1' : '0'; ?>">

            <div class="mb-3">
                <label for="Vendor_ID" class="form-label">Vendor ID</label>
                <input type="text" class="form-control" id="Vendor_ID" name="Vendor_ID" value="<?php echo $vendorData['Vendor_ID']; ?>" <?php echo $editMode ? 'readonly' : 'required'; ?>>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="Vendor_Type" class="form-label">Vendor Type</label>
                    <input type="text" class="form-control" id="Vendor_Type" name="Vendor_Type" value="<?php echo $vendorData['Vendor_Type']; ?>" required>
                </div>
                <div class="col">
                    <label for="Name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="Name" name="Name" value="<?php echo $vendorData['Name']; ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="Street" class="form-label">Street</label>
                    <input type="text" class="form-control" id="Street" name="Street" value="<?php echo $vendorData['Street']; ?>" required>
                </div>
                <div class="col">
                    <label for="City" class="form-label">City</label>
                    <input type="text" class="form-control" id="City" name="City" value="<?php echo $vendorData['City']; ?>" required>
                </div>
                <div class="col">
                    <label for="State" class="form-label">State</label>
                    <input type="text" class="form-control" id="State" name="State" value="<?php echo $vendorData['State']; ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="Meat_Type_Sold" class="form-label">Meat Type Sold</label>
                <input type="text" class="form-control" id="Meat_Type_Sold" name="Meat_Type_Sold" value="<?php echo $vendorData['Meat_Type_Sold']; ?>">
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="Contact_info" class="form-label">Contact Number</label>
                    <input type="text" class="form-control" id="Contact_info" name="Contact_info" value="<?php echo $vendorData['Contact_info']; ?>" required>
                </div>
                <div class="col">
                    <label for="Email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="Email" name="Email" value="<?php echo $vendorData['Email']; ?>" required>
                </div>
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary">
                    <?php echo $editMode ? 'Update Vendor' : 'Add Vendor'; ?>
                </button>
                <a href="f8.php#vendors" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
