<?php
include __DIR__ . '/db_connect.php';

$orderData = [
    'Order_ID' => '',
    'Order_Date' => '',
    'Meat_Type' => '',
    'Quantity' => '',
    'Unit_Price' => '',
    'Customer_ID' => ''
];

$editMode = false;

if (isset($_GET['edit'])) {
    $editMode = true;
    $orderId = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM Order_T WHERE Order_ID = ?");
    $stmt->bind_param("s", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    $orderData = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $editMode ? 'Edit Order' : 'Add New Order'; ?></title>
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
        <h2 class="text-center mb-4"><?php echo $editMode ? 'Edit Order Information' : 'Add New Order'; ?></h2>

        <form action="order_create.php" method="POST" class="card p-4 shadow-sm">
            <input type="hidden" name="editMode" value="<?php echo $editMode ? '1' : '0'; ?>">
            <?php if ($editMode): ?>
                <input type="hidden" name="Order_ID" value="<?php echo $orderData['Order_ID']; ?>">
            <?php endif; ?>

            <div class="mb-3">
                <label for="Order_Date" class="form-label">Order Date</label>
                <input type="date" class="form-control" id="Order_Date" name="order_date" value="<?php echo $orderData['Order_Date']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="Meat_Type" class="form-label">Meat Type</label>
                <input type="text" class="form-control" id="Meat_Type" name="meat_type" value="<?php echo $orderData['Meat_Type']; ?>" required>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="Quantity" class="form-label">Quantity (kg)</label>
                    <input type="number" step="0.01" class="form-control" id="Quantity" name="quantity" value="<?php echo $orderData['Quantity']; ?>" required>
                </div>
                <div class="col">
                    <label for="Unit_Price" class="form-label">Unit Price (TK/kg)</label>
                    <input type="number" step="0.01" class="form-control" id="Unit_Price" name="unit_price" value="<?php echo $orderData['Unit_Price']; ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="Customer_ID" class="form-label">Customer ID</label>
                <input type="text" class="form-control" id="Customer_ID" name="customer_id" value="<?php echo $orderData['Customer_ID']; ?>" required>
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary">
                    <?php echo $editMode ? 'Update Order' : 'Add Order'; ?>
                </button>
                <a href="read.php" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
