<?php
include __DIR__ . '/db_connect.php'; // Your DB connection file

// Fetch Warehouses
$warehouseResult = $conn->query("SELECT Warehouse_ID, Address, Location, Cold_Storage_Capacity, Current_inventory_Level, Meat_Type_Stored FROM Warehouse_T");

// Fetch Deliveries
$deliveryResult = $conn->query("SELECT Delivery_ID, Delivery_Date, Street, City, State, Zip, Warehouse_ID, Order_ID FROM Delivery_T");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Supply Chain Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    #searchInput { max-width: 350px; }
    .search-container { position: relative; }
    .search-container i {
      position: absolute;
      top: 50%;
      left: 12px;
      transform: translateY(-50%);
      color: #6c757d;
    }
    .search-container input { padding-left: 2.2rem; }
    .chart-container { position: relative; height: 300px; margin: 20px 0; }
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
    <div class="search-container">
      <div class="position-relative">
        <i class="bi bi-search"></i>
        <input type="text" id="searchInput" class="form-control" placeholder="Search all entries...">
      </div>
    </div>
    <div class="form-check form-switch">
      <input class="form-check-input" type="checkbox" id="viewToggle" onchange="toggleView()">
      <label class="form-check-label" for="viewToggle">Show Chart View</label>
    </div>
  </div>

  <!-- Warehouse Table / Chart View -->
  <div id="warehouseTableView">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h4 class="mb-0">Warehouses</h4>
      <a href="warehouse_form.php?type=warehouse" class="btn btn-primary">Add Warehouse Entry</a>
    </div>
    <div class="table-responsive mb-5">
      <table class="table table-bordered table-striped data-table">
        <thead class="table-dark">
          <tr>
            <th>Warehouse ID</th>
            <th>Address</th>
            <th>Location</th>
            <th>Cold Storage Capacity</th>
            <th>Inventory Level</th>
            <th>Meat Type</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $warehouseResult->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['Warehouse_ID']) ?></td>
              <td><?= htmlspecialchars($row['Address']) ?></td>
              <td><?= htmlspecialchars($row['Location']) ?></td>
              <td><?= htmlspecialchars($row['Cold_Storage_Capacity']) ?></td>
              <td><?= htmlspecialchars($row['Current_inventory_Level']) ?></td>
              <td><?= htmlspecialchars($row['Meat_Type_Stored']) ?></td>
              <td>
                <a href="warehouse_update.php?warehouse_id=<?= htmlspecialchars($row['Warehouse_ID']) ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="warehouse_delete.php?warehouse_id=<?= htmlspecialchars($row['Warehouse_ID']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this warehouse?')">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Delivery Table / Chart View -->
  <div id="deliveryTableView">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h4 class="mb-0">Deliveries</h4>
      <a href="delivery_form.php?type=delivery" class="btn btn-primary">Add Delivery Entry</a>
    </div>
    <div class="table-responsive">
      <table class="table table-bordered table-striped data-table">
        <thead class="table-dark">
          <tr>
            <th>Delivery ID</th>
            <th>Delivery Date</th>
            <th>Street</th>
            <th>City</th>
            <th>State</th>
            <th>Zip</th>
            <th>Warehouse ID</th>
            <th>Order ID</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $deliveryResult->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['Delivery_ID']) ?></td>
              <td><?= htmlspecialchars($row['Delivery_Date']) ?></td>
              <td><?= htmlspecialchars($row['Street']) ?></td>
              <td><?= htmlspecialchars($row['City']) ?></td>
              <td><?= htmlspecialchars($row['State']) ?></td>
              <td><?= htmlspecialchars($row['Zip']) ?></td>
              <td><?= htmlspecialchars($row['Warehouse_ID']) ?></td>
              <td><?= htmlspecialchars($row['Order_ID']) ?></td>
              <td>
                <a href="delivery_update.php?delivery_id=<?= htmlspecialchars($row['Delivery_ID']) ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="delivery_delete.php?delivery_id=<?= htmlspecialchars($row['Delivery_ID']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this delivery?')">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Warehouse Chart View -->
  <div id="warehouseChartView" style="display: none;">
    <h4 class="mb-0">Warehouse Inventory Levels (Chart)</h4>
    <div class="chart-container">
      <canvas id="warehouseChart"></canvas>
    </div>
  </div>

  <!-- Delivery Chart View -->
  <div id="deliveryChartView" style="display: none;">
    <h4 class="mb-0">Delivery Volume (Chart)</h4>
    <div class="chart-container">
      <canvas id="deliveryChart"></canvas>
    </div>
  </div>

</div>

<script>
  // Toggle between table and chart views
  function toggleView() {
    const isChart = document.getElementById('viewToggle').checked;
    document.getElementById('warehouseTableView').style.display = isChart ? 'none' : 'block';
    document.getElementById('deliveryTableView').style.display = isChart ? 'none' : 'block';
    document.getElementById('warehouseChartView').style.display = isChart ? 'block' : 'none';
    document.getElementById('deliveryChartView').style.display = isChart ? 'block' : 'none';
  }

  // Warehouse Chart (Inventory Levels)
  const warehouseData = {
    labels: ["Warehouse 1", "Warehouse 2", "Warehouse 3"],  // Example, change dynamically
    datasets: [{
      label: 'Cold Storage Capacity (Units)',
      data: [1200, 800, 1500],  // Example, change dynamically
      borderColor: '#FF5733',
      backgroundColor: '#FF57333D',
      borderWidth: 2,
      fill: true
    }]
  };

  const warehouseConfig = {
    type: 'bar',
    data: warehouseData,
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Cold Storage Capacity (Units)'
          }
        }
      }
    }
  };

  const warehouseChart = new Chart(document.getElementById('warehouseChart'), warehouseConfig);

  // Delivery Chart (Delivery Frequency)
  const deliveryData = {
    labels: ["Jan", "Feb", "Mar"],  // Example, change dynamically
    datasets: [{
      label: 'Deliveries per Month',
      data: [5, 7, 9],  // Example, change dynamically
      borderColor: '#008CBA',
      backgroundColor: '#008CBA3D',
      borderWidth: 2,
      fill: true
    }]
  };

  const deliveryConfig = {
    type: 'line',
    data: deliveryData,
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Number of Deliveries'
          }
        }
      }
    }
  };

  const deliveryChart = new Chart(document.getElementById('deliveryChart'), deliveryConfig);
</script>

</body>
</html>
