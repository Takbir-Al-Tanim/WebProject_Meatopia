<?php
include 'db_connect.php';

$query = "SELECT Batch_ID, Production_Date, Expiry_Date, Quantity, Storage_Location, Product_ID FROM batch_t";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Batch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="mb-4">Batch Data</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Batch ID</th>
                    <th>Production Date</th>
                    <th>Expiry Date</th>
                    <th>Quantity</th>
                    <th>Storage Location</th>
                    <th>Product ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['Batch_ID']); ?></td>
                        <td><?php echo htmlspecialchars($row['Production_Date']); ?></td>
                        <td><?php echo htmlspecialchars($row['Expiry_Date']); ?></td>
                        <td><?php echo htmlspecialchars($row['Quantity']); ?></td>
                        <td><?php echo htmlspecialchars($row['Storage_Location']); ?></td>
                        <td><?php echo htmlspecialchars($row['Product_ID']); ?></td>
                        <td>
                            <a href="edit_batch.php?id=<?php echo $row['Batch_ID']; ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="delete_batch.php?id=<?php echo $row['Batch_ID']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this batch?')">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
