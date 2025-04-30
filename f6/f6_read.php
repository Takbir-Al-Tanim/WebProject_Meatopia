<?php
include __DIR__ . '/db_connect.php'; // Include DB connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Farm & Livestock Recommendations</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
  <style>
    body { background-color: #f8f9fa; }
    .action-btns a { margin-right: 5px; }
    .table th { position: sticky; top: 0; background-color: #343a40; color: white; }
    .dt-buttons .btn { margin-right: 5px !important; }
    .btn-csv { background-color: #007bff; color: white; border: 1px solid #007bff; }
    .btn-csv:hover { background-color: #0056b3; border: 1px solid #0056b3; }
    .btn-pdf { background-color: #dc3545; color: white; border: 1px solid #dc3545; }
    .btn-pdf:hover { background-color: #c82333; border: 1px solid #c82333; }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">🐄 Farm & Livestock Dashboard</a>
  </div>
</nav>

<div class="container py-5">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <input type="text" class="form-control w-25" id="searchInput" onkeyup="searchById()" placeholder="Search by Cattle ID">
    <div>
      <a href="add_farm_livestock.php?mode=add&type=info" class="btn btn-primary">➕ Add Farm / Livestock Info</a>
      <a href="add_recommendation.php?mode=add&type=recommendation" class="btn btn-success">➕ Add New Recommendation</a>
    </div>
  </div>

  <!-- Livestock Table -->
  <div class="card p-4 shadow-sm mb-5">
    <h4 class="mb-3 fw-bold">Livestock Records</h4>
    <div class="table-responsive">
      <table class="table table-hover" id="cattleTable">
        <thead class="table-dark">
          <tr>
            <th>Cattle ID</th>
            <th>Breed</th>
            <th>Weight (kg)</th>
            <th>Age (months)</th>
            <th>Health Status</th>
            <th>Farm ID</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM Cattle_T";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                  echo "<tr>
                      <td>".htmlspecialchars($row["Cattle_ID"])."</td>
                      <td>".htmlspecialchars($row["Breed"])."</td>
                      <td>".htmlspecialchars($row["Weight"])."</td>
                      <td>".htmlspecialchars($row["Age"])."</td>
                      <td>".htmlspecialchars($row["Health"] )."</td>
                      <td>".htmlspecialchars($row["Farm_ID"])."</td>
                      <td class='action-btns'>
                        <a href='f6_edit_livestock.php?mode=edit&type=info&cattle_id=".$row["Cattle_ID"]."' class='btn btn-sm btn-warning'>✏️ Edit</a>
                        <a href='f6_delete_livestock.php?type=info&cattle_id=".$row["Cattle_ID"]."' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this livestock record?\")'>🗑️ Delete</a>
                      </td>
                  </tr>";
              }
          } else {
              echo "<tr><td colspan='7' class='text-center text-muted'>No livestock records found</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Recommendations Table -->
  <div class="card p-4 shadow-sm">
    <h4 class="mb-3 fw-bold">Recommendations</h4>
    <div class="table-responsive">
      <table class="table table-striped table-bordered" id="recommendationTable">
        <thead class="table-dark">
          <tr>
            <th>Recommendation ID</th>
            <th>Farm ID</th>
            <th>Cattle ID</th>
            <th>Recommendation</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM Recommendation_T";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                  echo "<tr>
                      <td>".htmlspecialchars($row["recommendation_ID"])."</td>
                      <td>".htmlspecialchars($row["Farm_ID"])."</td>
                      <td>".htmlspecialchars($row["Cattle_ID"])."</td>
                      <td>".htmlspecialchars($row["Recommendation_Text"])."</td>
                      <td class='action-btns'>
                        <a href='f6_edit_recommendation.php?mode=edit&type=recommendation&recommendation_id=".$row["recommendation_ID"]."' class='btn btn-sm btn-warning'>✏️ Edit</a>
                        <a href='f6_recommendation_delete.php?type=recommendation&recommendation_id=".$row["recommendation_ID"]."' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this recommendation?\")'>🗑️ Delete</a>
                      </td>
                  </tr>";
              }
          } else {
              echo "<tr><td colspan='5' class='text-center text-muted'>No recommendations found</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- JS Dependencies -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
// Search by cattle ID (existing)
function searchById() {
  const input = document.getElementById("searchInput").value.toUpperCase();
  const cattleRows = document.querySelectorAll("#cattleTable tbody tr");
  cattleRows.forEach(row => {
    const cattleId = row.cells[0]?.innerText.toUpperCase();
    row.style.display = cattleId.includes(input) ? "" : "none";
  });
}

// DataTable initialization
$(document).ready(function() {
  ['#cattleTable', '#recommendationTable'].forEach(function(selector) {
    $(selector).DataTable({
      paging: true,
      pageLength: 5,
      lengthChange: false,
      ordering: false,
      info: false,
      dom: 'Bfrtip',
      buttons: [
        { extend: 'csvHtml5', className: 'btn btn-csv btn-sm', text: '<i class="bi bi-file-earmark-spreadsheet"></i> Export CSV' },
        { extend: 'pdfHtml5', className: 'btn btn-pdf btn-sm', text: '<i class="bi bi-file-pdf"></i> Export PDF', orientation: 'landscape', pageSize: 'A4', exportOptions: { columns: ':visible' } }
      ],
      language: {
        search: '',
        searchPlaceholder: '🔍 Search table...'
      }
    });
    $(`${selector}_filter input`).addClass('form-control form-control-sm').css('width', '250px');
  });
});
</script>

</body>
</html>
<?php $conn->close(); ?>
