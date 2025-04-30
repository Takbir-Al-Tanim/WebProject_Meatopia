<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Livestock Management Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .welcome {
      padding-top: 100px;
      text-align: center;
    }
    #dataSection {
      padding: 50px 0;
    }
    .tab-content {
      padding: 20px;
      background-color: white;
      border: 1px solid #ddd;
      border-radius: 5px;
    }
    .tab-pane {
      padding-top: 20px;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="#"><i class="bi bi-house-fill me-2"></i>Production Data Management</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navDropdowns">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navDropdowns">
      <ul class="navbar-nav ms-auto">
        <!-- Add Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="addDropdown" role="button" data-bs-toggle="dropdown">
            <i class="bi bi-plus-circle me-1"></i>Add Data
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="add_livestock.php">Add Livestock</a></li>
            <li><a class="dropdown-item" href="add_batch.php">Add Batch</a></li>
            <li><a class="dropdown-item" href="add_slaughterhouse.php">Add Slaughterhouse</a></li>
          </ul>
        </li>

        <!-- View Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="viewDropdown" role="button" data-bs-toggle="dropdown">
            <i class="bi bi-table me-1"></i>View Data
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item view-link" data-type="livestock">View Livestock</a></li>
            <li><a class="dropdown-item view-link" data-type="batch">View Batches</a></li>
            <li><a class="dropdown-item view-link" data-type="slaughterhouse">View Slaughterhouse</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Welcome Section -->
<div class="welcome">
  <div class="container">
    <h1 class="text-dark">Welcome to the Livestock Management System</h1>
    <p class="text-muted">Choose an option from the menu above to begin.</p>
  </div>
</div>

<!-- Dynamic Data Section -->
<div class="container" id="dataSection">
  <!-- Tabs for viewing data -->
  <ul class="nav nav-tabs" id="dataTab" role="tablist">
    <li class="nav-item" role="presentation">
      <a class="nav-link active" id="livestock-tab" data-bs-toggle="tab" href="#livestock" role="tab" aria-controls="livestock" aria-selected="true">Livestock</a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="batch-tab" data-bs-toggle="tab" href="#batch" role="tab" aria-controls="batch" aria-selected="false">Batch</a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="slaughterhouse-tab" data-bs-toggle="tab" href="#slaughterhouse" role="tab" aria-controls="slaughterhouse" aria-selected="false">Slaughterhouse</a>
    </li>
  </ul>
  <div class="tab-content" id="dataTabContent">
    <!-- Livestock Tab -->
    <div class="tab-pane fade show active" id="livestock" role="tabpanel" aria-labelledby="livestock-tab">
      <!-- Livestock data will be loaded here -->
    </div>
    <!-- Batch Tab -->
    <div class="tab-pane fade" id="batch" role="tabpanel" aria-labelledby="batch-tab">
      <!-- Batch data will be loaded here -->
    </div>
    <!-- Slaughterhouse Tab -->
    <div class="tab-pane fade" id="slaughterhouse" role="tabpanel" aria-labelledby="slaughterhouse-tab">
      <!-- Slaughterhouse data will be loaded here -->
    </div>
  </div>
</div>

<!-- Bootstrap + AJAX + DataTables -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll(".view-link");
    const dataSection = document.getElementById("dataSection");

    links.forEach(link => {
      link.addEventListener("click", function (e) {
        e.preventDefault();
        const type = this.getAttribute("data-type");

        fetch(`view_${type}.php`)
          .then(response => response.text())
          .then(data => {
            // Load data into corresponding tab
            const tabContent = document.querySelector(`#${type}`).innerHTML = data;

            // Initialize DataTable after content is loaded
            $(document).ready(function() {
              $(`#${type} table`).DataTable({
                paging: true,
                pageLength: 5,
                lengthChange: false,
                ordering: false,
                info: false
              });
            });

            window.scrollTo({ top: dataSection.offsetTop, behavior: 'smooth' });
          })
          .catch(error => {
            dataSection.innerHTML = `<div class="alert alert-danger">Error loading data: ${error}</div>`;
          });
      });
    });
  });
</script>

</body>
</html>
