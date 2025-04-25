<?php
$mysqli = new mysqli("localhost", "root", "", "supply_chain");
if ($mysqli->connect_errno) {
    die("Failed to connect: " . $mysqli->connect_error);
}

$query = "
SELECT 
    w.Warehouse_ID, w.Warehouse_Name, w.Location, w.Cold_Storage_Capacity, w.Current_Inventory_Level, w.Meat_Type_Stored,
    d.Delivery_ID, d.Delivery_Date, d.Logistics_Partner, 
    CASE 
        WHEN w.Vendor_ID IS NOT NULL THEN 'Yes' 
        ELSE 'No' 
    END AS Cold_Chain_Compliance
FROM 
    warehouse w
LEFT JOIN 
    delivery d ON d.Warehouse_ID = w.Warehouse_ID
";

$result = $mysqli->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Supply Chain Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    #searchInput { max-width: 350px; }
    .search-container i { position: absolute; top: 50%; left: 12px; transform: translateY(-50%); color: #6c757d; }
    .search-container input { padding-left: 2.2rem; }
  </style>
</head>
<body class="bg-light">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Supply Chain Dashboard</a>
    </div>
  </nav>

  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div class="search-container position-relative">
        <i class="bi bi-search"></i>
        <input type="text" id="searchInput" class="form-control" placeholder="Search warehouse, location, meat type...">
      </div>
      <a href="f4_form.html" class="btn btn-primary">Add New Entry</a>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-striped" id="supplyTable">
        <thead class="table-dark">
          <tr>
            <th>Warehouse ID</th>
            <th>Location</th>
            <th>Capacity</th>
            <th>Inventory</th>
            <th>Meat Type</th>
            <th>Delivery ID</th>
            <th>Delivery Date</th>
            <th>Logistics Partner</th>
            <th>Cold Chain</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['Warehouse_ID'] ?></td>
            <td><?= $row['Location'] ?></td>
            <td><?= $row['Cold_Storage_Capacity'] ?></td>
            <td><?= $row['Current_Inventory_Level'] ?></td>
            <td><?= $row['Meat_Type_Stored'] ?></td>
            <td><?= $row['Delivery_ID'] ?></td>
            <td><?= $row['Delivery_Date'] ?></td>
            <td><?= $row['Logistics_Partner'] ?></td>
            <td><?= $row['Cold_Chain_Compliance'] ?></td>
            <td>
              <a href="edit_f4.php?id=<?= $row['Warehouse_ID'] ?>" class="btn btn-warning btn-sm">Edit</a>
              <a href="delete_f4.php?id=<?= $row['Warehouse_ID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    document.getElementById('searchInput').addEventListener('keyup', function () {
      const filter = this.value.toLowerCase();
      const rows = document.querySelectorAll('#supplyTable tbody tr');
      rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
      });
    });
  </script>
</body>
</html>
