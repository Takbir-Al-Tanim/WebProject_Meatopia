<?php 
include __DIR__ . '/db_connect.php';  // Database connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Comprehensive Meat Product Info</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Body and Table Styling */
    body {
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        height: 100vh;
    }

    /* Table container */
    .table-container {
        margin-top: 30px;
        flex-grow: 1; /* Allows the table container to expand */
        overflow-y: auto; /* Ensures scrolling when content overflows */
    }

    /* Search bar styling */
    .search-input {
        max-width: 400px;
        width: 100%;
    }

    /* Optional: To make the header sticky */
    thead th {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #343a40;
    }

    /* Table styling for consistent column widths */
    table th, table td {
        white-space: nowrap;
    }

    table th:nth-child(1), table td:nth-child(1) {
        width: 10%;
    }

    table th:nth-child(2), table td:nth-child(2) {
        width: 15%;
    }

    table th:nth-child(3), table td:nth-child(3) {
        width: 15%;
    }

    table th:nth-child(4), table td:nth-child(4) {
        width: 10%;
    }

    table th:nth-child(5), table td:nth-child(5) {
        width: 10%;
    }

    table th:nth-child(6), table td:nth-child(6) {
        width: 10%;
    }

    table th:nth-child(7), table td:nth-child(7) {
        width: 10%;
    }

    table th:nth-child(8), table td:nth-child(8) {
        width: 10%;
    }

    table th:nth-child(9), table td:nth-child(9) {
        width: 10%;
    }

    table th:nth-child(10), table td:nth-child(10) {
        width: 10%;
    }

    /* Optional: Make the table scrollable on smaller screens */
    .table-responsive {
        max-height: calc(100vh - 200px); /* Allow the table to be scrollable */
        overflow-y: auto;
    }

  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">🥩 Meat Supply Dashboard</a>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="container table-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2>Comprehensive Product Information</h2>
      <a href="f1_update.php" class="btn btn-primary">➕ Add New Product</a>
    </div>
    
    <div class="input-group mb-4" style="max-width: 400px;">
      <span class="input-group-text bg-primary text-white" id="search-icon">🔍</span>
      <input type="text" class="form-control" id="searchInput" placeholder="Search meat type or cuts..." aria-label="Search">
    </div>
      
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-hover" id="productTable">
        <thead class="table-dark">
          <tr>
            <th>Product ID</th>
            <th>Meat Type</th>
            <th>Cut Type</th>
            <th>Country</th>
            <th>Region</th>
            <th>Seasonality</th>
            <th>Certifications</th>
            <th>Fat Content</th>
            <th>Grade</th>
            <th>Cattle ID</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM Product_T";  // ✅ Correct table name
          $result = $conn->query($sql);
          
          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                  echo "<tr>
                      <td>".$row["Product_ID"]."</td>
                      <td>".$row["Meat_Type"]."</td>
                      <td>".$row["Cut_Type"]."</td>
                      <td>".$row["Country"]."</td>
                      <td>".$row["Region"]."</td>
                      <td>".$row["Seasonality"]."</td>
                      <td>".$row["Certifications"]."</td>
                      <td>".$row["Fat_Content"]."</td>
                      <td>".$row["Grade"]."</td>
                      <td>".$row["Cattle_ID"]."</td>
                      <td>
                        <a href='f1_form.php?edit=".$row["Product_ID"]."' class='btn btn-sm btn-warning'>✏️ Edit</a>
                        <a href='f1_delete.php?id=".$row["Product_ID"]."' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\")'>🗑️ Delete</a>
                      </td>
                  </tr>";
              }
          } else {
              echo "<tr><td colspan='10' class='text-center'>No products found</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    // Filter table based on search input
    document.getElementById("searchInput").addEventListener("keyup", function() {
      const searchValue = this.value.toLowerCase();
      const rows = document.querySelectorAll("#productTable tbody tr");
      rows.forEach(row => {
        const rowText = row.innerText.toLowerCase();
        row.style.display = rowText.includes(searchValue) ? "" : "none";
      });
    });
  </script>

</body>
</html>
<?php $conn->close(); ?>
