<?php 
include __DIR__ . '/db_connect.php';  // Database connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Meat Product Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
  <style>
    body { background-color: #f8f9fa; padding-bottom: 50px; }
    .table-container, .chart-container { display: none; }
    .pagination { justify-content: center; }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">🥩 Meat Dashboard</a>
  </div>
</nav>

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Product Data</h2>
    <a href="f1_update.php" class="btn btn-primary">➕ Add Product</a>
  </div>
  <div class="form-check form-switch mb-3">
    <input class="form-check-input" type="checkbox" role="switch" id="viewToggle">
    <label class="form-check-label" for="viewToggle">Toggle Chart/Table</label>
  </div>
  <div class="mb-3">
    <input type="text" class="form-control" id="searchInput" placeholder="Search meat type or cuts...">
  </div>
  <div class="mb-3">
    <button class="btn btn-outline-success me-2" onclick="exportCSV()">Export CSV</button>
    <button class="btn btn-outline-danger" onclick="exportPDF()">Export PDF</button>
  </div>
</div>

<div class="container chart-container" id="chartSection">
  <h4 class="text-center">Meat Type Distribution</h4>
  <canvas id="meatChart"></canvas>
</div>

<div class="container table-container" id="tableSection">
  <div class="table-responsive">
    <table class="table table-bordered" id="productTable">
      <thead class="table-dark">
        <tr>
          <th>Product ID</th><th>Meat Type</th><th>Cut Type</th><th>Country</th><th>Region</th>
          <th>Seasonality</th><th>Certifications</th><th>Fat Content</th><th>Grade</th><th>Cattle ID</th><th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $data = [];
        $labels = [];
        $counts = [];

        $sql = "SELECT * FROM Product_T";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
              <td>{$row['Product_ID']}</td>
              <td>{$row['Meat_Type']}</td>
              <td>{$row['Cut_Type']}</td>
              <td>{$row['Country']}</td>
              <td>{$row['Region']}</td>
              <td>{$row['Seasonality']}</td>
              <td>{$row['Certifications']}</td>
              <td>{$row['Fat_Content']}</td>
              <td>{$row['Grade']}</td>
              <td>{$row['Cattle_ID']}</td>
              <td>
                <a href='f1_form.php?edit={$row['Product_ID']}' class='btn btn-sm btn-warning'>✏️</a>
                <a href='f1_delete.php?id={$row['Product_ID']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\")'>🗑️</a>
              </td>
            </tr>";
          }
        }

        // For chart data
        $chartSql = "SELECT Meat_Type, COUNT(*) as count FROM Product_T GROUP BY Meat_Type";
        $chartRes = $conn->query($chartSql);
        while ($r = $chartRes->fetch_assoc()) {
          $labels[] = $r['Meat_Type'];
          $counts[] = $r['count'];
        }
        ?>
      </tbody>
    </table>
  </div>
  <nav><ul class="pagination"></ul></nav>
</div>

<script>
  const labels = <?php echo json_encode($labels); ?>;
  const counts = <?php echo json_encode($counts); ?>;

  const chart = new Chart(document.getElementById('meatChart'), {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Product Count',
        data: counts,
        backgroundColor: 'rgba(75,192,192,0.7)',
        borderColor: 'rgba(75,192,192,1)',
        borderWidth: 1
      }]
    },
    options: {
      scales: { y: { beginAtZero: true } },
      responsive: true
    }
  });

  const toggle = document.getElementById("viewToggle");
  const chartSection = document.getElementById("chartSection");
  const tableSection = document.getElementById("tableSection");
  chartSection.style.display = "none";
  tableSection.style.display = "block";
  toggle.addEventListener("change", () => {
    chartSection.style.display = toggle.checked ? "block" : "none";
    tableSection.style.display = toggle.checked ? "none" : "block";
  });

  document.getElementById("searchInput").addEventListener("input", function() {
    const val = this.value.toLowerCase();
    document.querySelectorAll("#productTable tbody tr").forEach(row => {
      row.style.display = row.innerText.toLowerCase().includes(val) ? "" : "none";
    });
  });

  function exportCSV() {
    const rows = [...document.querySelectorAll("#productTable tr")].map(tr => [...tr.children].map(td => td.innerText));
    const csv = rows.map(r => r.join(",")).join("\n");
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = "meat_products.csv";
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
  }

  function exportPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    doc.text("Meat Product Table", 14, 16);
    doc.autoTable({ html: '#productTable', startY: 20 });
    doc.save('meat_products.pdf');
  }

  const rowsPerPage = 10;
  const table = document.getElementById("productTable");
  const rows = Array.from(table.querySelectorAll("tbody tr"));
  const pagination = document.querySelector(".pagination");
  let currentPage = 1;

  function displayPage(page) {
    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    rows.forEach((r, i) => r.style.display = (i >= start && i < end) ? "" : "none");
    pagination.innerHTML = "";
    const pageCount = Math.ceil(rows.length / rowsPerPage);
    for (let i = 1; i <= pageCount; i++) {
      const li = document.createElement("li");
      li.className = "page-item" + (i === page ? " active" : "");
      li.innerHTML = `<a class='page-link' href='#'>${i}</a>`;
      li.addEventListener("click", () => displayPage(i));
      pagination.appendChild(li);
    }
  }
  displayPage(currentPage);
</script>
</body>
</html>
<?php $conn->close(); ?>
