<?php
include __DIR__ . '/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $delivery_id = $_POST['Delivery_ID'];
    $delivery_date = $_POST['Delivery_Date'];
    $street = $_POST['Street'];
    $city = $_POST['City'];
    $state = $_POST['State'];
    $zip = $_POST['Zip'];
    $batch_id = $_POST['Batch_ID'];
    $warehouse_id = $_POST['Warehouse_ID'];
    $order_id = $_POST['Order_ID'];

    $sql = "UPDATE Delivery_T 
            SET Delivery_Date = ?, Street = ?, City = ?, State = ?, Zip = ?, Batch_ID = ?, Warehouse_ID = ?, Order_ID = ?
            WHERE Delivery_ID = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssis", $delivery_date, $street, $city, $state, $zip, $batch_id, $warehouse_id, $order_id, $delivery_id);

    if ($stmt->execute()) {
        header("Location: f4_read.php");
        exit;
    } else {
        echo "Error updating record: " . $stmt->error;
    }
} else {
    if (isset($_GET['delivery_id'])) {
        $delivery_id = $_GET['delivery_id'];
        $sql = "SELECT * FROM Delivery_T WHERE Delivery_ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $delivery_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    } else {
        echo "No Delivery_ID provided.";
        exit;
    }
}
?>

<!-- Edit Form -->
<!DOCTYPE html>
<html>
<head>
    <title>Edit Delivery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2>Edit Delivery</h2>
    <form method="POST" action="delivery_update.php">
        <input type="hidden" name="Delivery_ID" value="<?= htmlspecialchars($row['Delivery_ID']) ?>">

        <div class="mb-3"><label>Delivery Date</label>
            <input type="date" name="Delivery_Date" class="form-control" value="<?= $row['Delivery_Date'] ?>"></div>

        <div class="mb-3"><label>Street</label>
            <input type="text" name="Street" class="form-control" value="<?= $row['Street'] ?>"></div>

        <div class="mb-3"><label>City</label>
            <input type="text" name="City" class="form-control" value="<?= $row['City'] ?>"></div>

        <div class="mb-3"><label>State</label>
            <input type="text" name="State" class="form-control" value="<?= $row['State'] ?>"></div>

        <div class="mb-3"><label>Zip</label>
            <input type="text" name="Zip" class="form-control" value="<?= $row['Zip'] ?>"></div>

        <div class="mb-3"><label>Batch ID</label>
            <input type="text" name="Batch_ID" class="form-control" value="<?= $row['Batch_ID'] ?>"></div>

        <div class="mb-3"><label>Warehouse ID</label>
            <input type="text" name="Warehouse_ID" class="form-control" value="<?= $row['Warehouse_ID'] ?>"></div>

        <div class="mb-3"><label>Order ID</label>
            <input type="number" name="Order_ID" class="form-control" value="<?= $row['Order_ID'] ?>"></div>

        <button class="btn btn-primary">Update</button>
        <a href="f4_read.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
