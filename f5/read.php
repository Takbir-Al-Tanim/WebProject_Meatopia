<?php
include __DIR__ . '/db_connect.php';
$sql = "SELECT Order_ID, Order_Date, Meat_Type, Quantity, List_Price, Unit_Price, Customer_ID FROM Order_T";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Order Dashboard | Meatopia</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<style>
body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
.chart-container { position: relative; height: 350px; margin: 20px 0; }
.card { border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border: none; }
.card-header { border-radius: 10px 10px 0 0 !important; font-weight: 600; letter-spacing: 0.5px; }
.nav-tabs .nav-link { font-weight: 500; border: none; color: #495057; }
.nav-tabs .nav-link.active { color: #0d6efd; border-bottom: 3px solid #0d6efd; background: transparent; }
.action-btns button { margin-right: 5px; min-width: 70px; }
.table th { background-color: #343a40; color: white; position: sticky; top: 0; }
.dt-buttons .btn { border-radius: 50px !important; padding: 6px 16px; font-weight: 500; }
</style>
</head>

<body class="bg-light">
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <input type="text" class="form-control w-25" id="searchInput" onkeyup="searchById()" placeholder="🔍 Search by Order ID">
    <a href="f5_form.php" class="btn btn-primary px-4" id="addOrderBtn">
      <i class="bi bi-plus-lg"></i> Add Order
    </a>
  </div>

  <div class="form-check form-switch mb-4">
    <input class="form-check-input" type="checkbox" id="viewToggle" onchange="toggleView()">
    <label class="form-check-label" for="viewToggle">Show Chart View</label>
  </div>

  <div id="tableView">
    <div class="card p-4 mb-4">
      <h4 class="mb-3 text-dark">Order Records</h4>
      <div class="table-responsive">
        <table class="table table-hover" id="orderTable">
          <thead>
            <tr>
              <th>Order ID</th>
              <th>Date</th>
              <th>Meat Type</th>
              <th>Quantity (kg)</th>
              <th>Total Price (TK/kg)</th>
              <th>Unit Price (TK/kg)</th>
              <th>Customer ID</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($result->num_rows > 0) { while ($row = $result->fetch_assoc()) { ?>
              <tr>
                <td><?= 'ORD' . str_pad($row['Order_ID'], 4, '0', STR_PAD_LEFT) ?></td>
                <td><?= date('M d, Y', strtotime($row['Order_Date'])) ?></td>
                <td><?= $row['Meat_Type'] ?></td>
                <td><?= number_format($row['Quantity'], 2) ?></td>
                <td>৳<?= number_format($row['List_Price'], 2) ?></td>
                <td>৳<?= number_format($row['Unit_Price'], 2) ?></td>
                <td><?= 'CUST' . str_pad($row['Customer_ID'], 4, '0', STR_PAD_LEFT) ?></td>
                <td class="action-btns">
                  <a href="f5_form.php?edit=<?= $row['Order_ID'] ?>" class="btn btn-sm btn-warning">Edit</a>
                  <a href="order_delete.php?id=<?= $row['Order_ID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
                </td>
              </tr>
            <?php }} else { ?>
              <tr><td colspan="8" class="text-center text-muted">No orders found.</td></tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div id="chartView" style="display: none;">
    <ul class="nav nav-tabs mb-3" id="chartTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="historical-tab" data-bs-toggle="tab" data-bs-target="#historical" type="button" role="tab">
          <i class="bi bi-graph-up"></i> Historical Trends
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="current-tab" data-bs-toggle="tab" data-bs-target="#current" type="button" role="tab">
          <i class="bi bi-bar-chart"></i> Current Prices
        </button>
      </li>
    </ul>

    <div class="tab-content">
      <div class="tab-pane fade show active" id="historical" role="tabpanel">
        <div class="card">
          <div class="card-header bg-primary text-white">Historical Price Trends (Avg ৳/kg)</div>
          <div class="card-body">
            <div class="chart-container">
              <canvas id="historicalChart"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="current" role="tabpanel">
        <div class="card">
          <div class="card-header bg-primary text-white">Current Price Comparison (৳/kg)</div>
          <div class="card-body">
            <div class="chart-container">
              <canvas id="currentChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
// Search Function
function searchById() {
  const input = document.getElementById("searchInput").value.toUpperCase().replace('ORD', '');
  const tr = document.getElementById("orderTable").getElementsByTagName("tr");
  for (let i = 1; i < tr.length; i++) {
    const td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      let tdText = td.textContent.toUpperCase().replace('ORD', '');
      tr[i].style.display = tdText.includes(input) ? "" : "none";
    }
  }
}

// Toggle View
function toggleView() {
  const isChart = document.getElementById('viewToggle').checked;
  document.getElementById('tableView').style.display = isChart ? 'none' : 'block';
  document.getElementById('chartView').style.display = isChart ? 'block' : 'none';
  document.getElementById('searchInput').style.display = isChart ? 'none' : 'inline-block';
  document.getElementById('addOrderBtn').style.display = isChart ? 'none' : 'inline-block';
}

// DataTable Init
$(document).ready(function() {
  $('#orderTable').DataTable({
    pageLength: 5,
    dom: 'Bfrtip',
    buttons: [{
      extend: 'collection',
      text: '<i class="bi bi-download me-1"></i> Export',
      className: 'btn btn-outline-dark btn-sm rounded-pill',
      autoClose: true,
      buttons: [
        {
          extend: 'csvHtml5',
          text: '<i class="bi bi-file-earmark-spreadsheet me-1"></i> CSV',
          className: 'dropdown-item',
          exportOptions: { columns: ':visible' }
        },
        {
          extend: 'pdfHtml5',
          text: '<i class="bi bi-file-pdf me-1"></i> PDF',
          className: 'dropdown-item',
          orientation: 'landscape',
          pageSize: 'A4',
          exportOptions: { columns: ':visible' }
        }
      ]
    }]
  });
});

// Chart Colors & Options
const meatColors = { Beef: '#E63946', Chicken: '#FFBE0B', Mutton: '#F8961E', Lamb: '#3A86FF' };
const chartOptions = {
  responsive: true, maintainAspectRatio: false,
  plugins: {
    legend: { position: 'top', labels: { font: { size: 13 }, padding: 20, usePointStyle: true, pointStyle: 'circle' } },
    tooltip: {
      backgroundColor: 'rgba(0,0,0,0.8)', titleFont: { size: 14, weight: 'bold' },
      bodyFont: { size: 13 }, padding: 12, cornerRadius: 8, displayColors: true,
      callbacks: { label: ctx => ` ${ctx.dataset.label}: ৳${ctx.raw.toFixed(2)}` }
    }
  },
  scales: {
    y: {
      beginAtZero: false, grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
      ticks: { callback: value => '৳' + value.toFixed(2) },
      title: { display: true, text: 'Price per kg (৳)', font: { size: 13, weight: 'bold' } }
    },
    x: {
      grid: { display: false },
      title: { display: true, text: 'Year', font: { size: 13, weight: 'bold' } }
    }
  }
};

// Historical Chart
fetch('historical_data.php')
  .then(res => res.json())
  .then(data => {
    const years = new Set();
    Object.values(data).forEach(meat => Object.keys(meat).forEach(year => years.add(year)));
    const labels = Array.from(years).sort();
    const datasets = Object.entries(data).map(([meat, prices]) => {
      const color = meatColors[meat] || '#333';
      return {
        label: `${meat} (৳/kg)`,
        data: labels.map(year => prices[year] || null),
        borderColor: color, backgroundColor: color + '33', pointBackgroundColor: color,
        borderWidth: 3, tension: 0.2, fill: true
      };
    });
    new Chart(document.getElementById('historicalChart'), { type: 'line', data: { labels, datasets }, options: chartOptions });
  });

// Current Chart
fetch('current_data.php')
  .then(res => res.json())
  .then(data => {
    const labels = data.map(e => e.label);
    const values = data.map(e => e.value);
    const colors = labels.map(meat => meatColors[meat] || '#333');
    new Chart(document.getElementById('currentChart'), {
      type: 'bar',
      data: { labels, datasets: [{ label: 'Current Price (৳/kg)', data: values, backgroundColor: colors.map(c => c + 'CC'), borderColor: colors, borderWidth: 1, borderRadius: 6 }] },
      options: { ...chartOptions, plugins: { ...chartOptions.plugins, legend: { display: false } } }
    });
  });
</script>

</body>
</html>
