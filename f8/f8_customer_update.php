<?php
include __DIR__ . '/db_connect.php';

$customerData = [
    'Customer_ID' => '',
    'Name' => '',
    'Street' => '',
    'City' => '',
    'State' => '',
    'Preferred_Meat_Type' => '',
    'Contact_Number' => '',
    'Email' => ''
];

$editMode = false;

if (isset($_GET['edit'])) {
    $editMode = true;
    $customerId = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM Customer_T WHERE Customer_ID = ?");
    $stmt->bind_param("s", $customerId);
    $stmt->execute();
    $result = $stmt->get_result();
    $customerData = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $editMode ? 'Edit Customer' : 'Add New Customer'; ?></title>
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
        <h2 class="text-center mb-4"><?php echo $editMode ? 'Edit Customer Information' : 'Add New Customer'; ?></h2>

        <form action="customer_create.php" method="POST" class="card p-4 shadow-sm">
            <input type="hidden" name="editMode" value="<?php echo $editMode ? '1' : '0'; ?>">

            <div class="mb-3">
                <label for="Customer_ID" class="form-label">Customer ID</label>
                <input type="text" class="form-control" id="Customer_ID" name="Customer_ID" value="<?php echo $customerData['Customer_ID']; ?>" <?php echo $editMode ? 'readonly' : 'required'; ?>>
            </div>

            <div class="mb-3">
                <label for="Name" class="form-label">Name</label>
                <input type="text" class="form-control" id="Name" name="Name" value="<?php echo $customerData['Name']; ?>" required>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="Street" class="form-label">Street</label>
                    <input type="text" class="form-control" id="Street" name="Street" value="<?php echo $customerData['Street']; ?>" required>
                </div>
                <div class="col">
                    <label for="City" class="form-label">City</label>
                    <input type="text" class="form-control" id="City" name="City" value="<?php echo $customerData['City']; ?>" required>
                </div>
                <div class="col">
                    <label for="State" class="form-label">State</label>
                    <input type="text" class="form-control" id="State" name="State" value="<?php echo $customerData['State']; ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="Preferred_Meat_Type" class="form-label">Preferred Meat Type</label>
                <input type="text" class="form-control" id="Preferred_Meat_Type" name="Preferred_Meat_Type" value="<?php echo $customerData['Preferred_Meat_Type']; ?>">
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="Contact_Number" class="form-label">Contact Number</label>
                    <input type="text" class="form-control" id="Contact_Number" name="Contact_Number" value="<?php echo $customerData['Contact_Number']; ?>" required>
                </div>
                <div class="col">
                    <label for="Email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="Email" name="Email" value="<?php echo $customerData['Email']; ?>" required>
                </div>
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary">
                    <?php echo $editMode ? 'Update Customer' : 'Add Customer'; ?>
                </button>
                <a href="f8.php#customers" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
