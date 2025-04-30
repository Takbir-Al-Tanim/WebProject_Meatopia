<?php
include __DIR__ . '/db_connect.php';

// Error/Success handling
$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';

// Pagination setup
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 10;
$offset = ($page - 1) * $perPage;

// Filter parameters
$meatFilter = $_GET['meat'] ?? '';
$startDate = $_GET['start'] ?? '';
$endDate = $_GET['end'] ?? '';

// Base query with filters
$sql = "SELECT SQL_CALC_FOUND_ROWS Order_ID, Order_Date, Meat_Type, Quantity, List_Price, Unit_Price, Customer_ID FROM Order_T WHERE 1=1";
$params = [];
$types = '';

if (!empty($meatFilter)) {
    $sql .= " AND Meat_Type = ?";
    $params[] = $meatFilter;
    $types .= 's';
}

if (!empty($startDate)) {
    $sql .= " AND Order_Date >= ?";
    $params[] = $startDate;
    $types .= 's';
}

if (!empty($endDate)) {
    $sql .= " AND Order_Date <= ?";
    $params[] = $endDate;
    $types .= 's';
}

$sql .= " ORDER BY Order_Date DESC LIMIT ? OFFSET ?";
$params[] = $perPage;
$params[] = $offset;
$types .= 'ii';

// Prepare and execute query
$stmt = $conn->prepare($sql);
if ($types) $stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Get total rows
$totalRows = $conn->query("SELECT FOUND_ROWS()")->fetch_row()[0];
$totalPages = ceil($totalRows / $perPage);

// Export data
$exportData = $conn->query("SELECT * FROM Order_T")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Dashboard | Meatopia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
  <style>
    body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    .chart-container { position: relative; height: 350px; margin: 20px 0; }
    .card { border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border: none; }
    .card-header { border-radius: 10px 10px 0 0 !important; font-weight: 600; letter-spacing: 0.5px; }
    .nav-tabs .nav-link { font-weight: 500; border: none; color: #495057; }
    .nav-tabs .nav-link.active { color: #0d6efd; border-bottom: 3px solid #0d6efd; background: transparent; }
    .action-btns button { margin-right: 5px; min-width: 70px; }
    .table th { background-color: #343a40; color: white; position: sticky; top: 0; }
    @media (max-width: 768px) {
        .table-responsive { overflow-x: auto; }
        .action-btns button { margin: 2px; }
    }
  </style>
</head>
<body class="bg-light">

<div class="container py-4">
    <?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= htmlspecialchars($error) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
    
    <?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= htmlspecialchars($success) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <button class="btn btn-success btn-sm" onclick="exportCSV()">
                <i class="bi bi-file-earmark-spreadsheet"></i> CSV
            </button>
            <button class="btn btn-danger btn-sm" onclick="exportPDF()">
                <i class="bi bi-file-pdf"></i> PDF
            </button>
        </div>
        <div class="d-flex gap-3">
            <input type="text" class="form-control" id="searchInput" placeholder="🔍 Search by Order ID" onkeyup="searchById()">
            <a href="f5_form.php" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Add Order
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <select class="form-select" id="meatFilter">
                <option value="">All Meat Types</option>
                <?php
                $types = $conn->query("SELECT DISTINCT Meat_Type FROM Order_T");
                while($type = $types->fetch_assoc()) {
                    $selected = $type['Meat_Type'] === $meatFilter ? 'selected' : '';
                    echo '<option '.$selected.'>'.htmlspecialchars($type['Meat_Type']).'</option>';
                }
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <input type="date" class="form-control" id="startDate" value="<?= htmlspecialchars($startDate) ?>">
        </div>
        <div class="col-md-3">
            <input type="date" class="form-control" id="endDate" value="<?= htmlspecialchars($endDate) ?>">
        </div>
        <div class="col-md-3">
            <button class="btn btn-secondary w-100" onclick="applyFilters()">Apply Filters</button>
        </div>
    </div>

    <div class="form-check form-switch mb-4">
        <input class="form-check-input" type="checkbox" id="viewToggle" onchange="toggleView()">
        <label class="form-check-label" for="viewToggle">Show Chart View</label>
    </div>

    <!-- Table View -->
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
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= 'ORD' . str_pad($row['Order_ID'], 4, '0', STR_PAD_LEFT) ?></td>
                                <td><?= date('M d, Y', strtotime($row['Order_Date'])) ?></td>
                                <td><?= htmlspecialchars($row['Meat_Type']) ?></td>
                                <td><?= number_format($row['Quantity'], 2) ?></td>
                                <td>৳<?= number_format($row['List_Price'], 2) ?></td>
                                <td>৳<?= number_format($row['Unit_Price'], 2) ?></td>
                                <td><?= 'CUST' . str_pad($row['Customer_ID'], 4, '0', STR_PAD_LEFT) ?></td>
                                <td class="action-btns">
                                    <a href="f5_form.php?edit=<?= $row['Order_ID'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="order_delete.php?id=<?= $row['Order_ID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="8" class="text-center text-muted">No orders found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&meat=<?= $meatFilter ?>&start=<?= $startDate ?>&end=<?= $endDate ?>">
                            <?= $i ?>
                        </a>
                    </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Chart View -->
    <div id="chartView" style="display: none;">
        <!-- Existing Chart Tabs Content -->
        <!-- ... [Keep original chart view code unchanged] ... -->
    </div>
</div>

<script>
// Export Functions (From 1.php)
function exportCSV() {
    const csvContent = "data:text/csv;charset=utf-8," 
        + [['ID','Date','Meat Type','Quantity','Price','Customer']]
          .concat(<?= json_encode($exportData) ?>.map(row => [
            `ORD${row.Order_ID.toString().padStart(4, '0')}`,
            new Date(row.Order_Date).toISOString().split('T')[0],
            row.Meat_Type,
            row.Quantity,
            row.Unit_Price,
            `CUST${row.Customer_ID.toString().padStart(4, '0')}`
          ]))
          .map(e => e.join(","))
          .join("\n");
    
    const link = document.createElement('a');
    link.href = encodeURI(csvContent);
    link.download = 'orders.csv';
    link.click();
}

function exportPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    
    doc.autoTable({
        head: [['ID', 'Date', 'Meat Type', 'Quantity', 'Price', 'Customer']],
        body: <?= json_encode($exportData) ?>.map(row => [
            `ORD${row.Order_ID.toString().padStart(4, '0')}`,
            new Date(row.Order_Date).toLocaleDateString(),
            row.Meat_Type,
            `${row.Quantity} kg`,
            `৳${row.Unit_Price.toFixed(2)}`,
            `CUST${row.Customer_ID.toString().padStart(4, '0')}`
        ]),
        theme: 'grid',
        styles: { fontSize: 10 },
        headStyles: { fillColor: [41, 128, 185] }
    });

    doc.save('orders.pdf');
}

// Filter Application
function applyFilters() {
    const params = new URLSearchParams({
        meat: document.getElementById('meatFilter').value,
        start: document.getElementById('startDate').value,
        end: document.getElementById('endDate').value,
        page: 1
    });
    window.location.href = `read.php?${params.toString()}`;
}

// Keep existing chart view toggle and search functions
// ... [Original toggleView() and searchById() functions] ...
</script>

<!-- Rest of original chart initialization code -->
<!-- ... [Keep original Chart.js code] ... -->

</body>
</html>
<?php $conn->close(); ?>