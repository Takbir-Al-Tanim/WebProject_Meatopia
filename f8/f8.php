<?php 
include __DIR__ . '/db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Buyer & Seller Directory</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

  <style>
    body {
        background-color: #f8f9fa;
        height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .table-container {
        margin-top: 30px;
        width: 100%;
        flex-grow: 1;
        padding-bottom: 30px;
        overflow-y: auto;
    }

    nav.navbar {
        z-index: 1000;
    }

    .tab-content {
        padding-top: 20px;
    }

    table th, table td {
        white-space: nowrap;
    }

    .dataTables_wrapper .dt-buttons {
        margin-bottom: 10px;
    }

    .top-list h5 {
        margin-top: 20px;
    }
  </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Buyer & Seller Directory</a>
  </div>
</nav>

<div class="container table-container">
  <ul class="nav nav-tabs" id="directoryTabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="farms-tab" data-bs-toggle="tab" data-bs-target="#farms" type="button" role="tab">Farms</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="vendors-tab" data-bs-toggle="tab" data-bs-target="#vendors" type="button" role="tab">Vendors</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="customers-tab" data-bs-toggle="tab" data-bs-target="#customers" type="button" role="tab">Customers</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="top-tab" data-bs-toggle="tab" data-bs-target="#toplists" type="button" role="tab">Top Buyers/Sellers</button>
    </li>
  </ul>

  <div class="tab-content" id="directoryTabsContent">
    <!-- Farms Tab -->
    <div class="tab-pane fade show active" id="farms" role="tabpanel" aria-labelledby="farms-tab">
      <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
        <h2>Farms</h2>
        <a href="f8_farm_update.php" class="btn btn-primary">➕ Add New Farm</a>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover datatable" id="farmTable">
          <thead class="table-dark">
            <tr>
              <th>Farm ID</th>
              <th>Name</th>
              <th>Address</th>
              <th>City</th>
              <th>State</th>
              <th>Certification</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT * FROM Farm_T";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>".$row["Farm_ID"]."</td>
                    <td>".$row["Name"]."</td>
                    <td>".$row["Street"]."</td>
                    <td>".$row["City"]."</td>
                    <td>".$row["State"]."</td>
                    <td>".$row["Certification"]."</td>
                    <td>".$row["ContactNumber"]."</td>
                    <td>".$row["Email"]."</td>
                    <td>
                      <a href='f8_farm_update.php?edit=".$row["Farm_ID"]."' class='btn btn-sm btn-warning'>✏️ Edit</a>
                      <a href='f8_farm_delete.php?id=".$row["Farm_ID"]."' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\")'>🗑️ Delete</a>
                    </td>
                  </tr>";
              }
            } else {
              echo "<tr><td colspan='9' class='text-center'>No farms found</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Vendors Tab -->
    <div class="tab-pane fade" id="vendors" role="tabpanel" aria-labelledby="vendors-tab">
      <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
        <h2>Vendors</h2>
        <a href="f8_vendor_update.php" class="btn btn-primary">➕ Add New Vendor</a>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover datatable" id="vendorTable">
          <thead class="table-dark">
            <tr>
              <th>Vendor ID</th>
              <th>Vendor Type</th>
              <th>Name</th>
              <th>Address</th>
              <th>City</th>
              <th>State</th>
              <th>Meat Type</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT * FROM Vendor_T";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>".$row["Vendor_ID"]."</td>
                    <td>".$row["Vendor_Type"]."</td>
                    <td>".$row["Name"]."</td>
                    <td>".$row["Street"]."</td>
                    <td>".$row["City"]."</td>
                    <td>".$row["State"]."</td>
                    <td>".$row["Meat_Type_Sold"]."</td>
                    <td>".$row["Contact_info"]."</td>
                    <td>".$row["Email"]."</td>
                    <td>
                      <a href='f8_vendor_update.php?edit=".$row["Vendor_ID"]."' class='btn btn-sm btn-warning'>✏️ Edit</a>
                      <a href='vendor_delete.php?id=".$row["Vendor_ID"]."' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\")'>🗑️ Delete</a>
                    </td>
                  </tr>";
              }
            } else {
              echo "<tr><td colspan='10' class='text-center'>No vendors found</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Customers Tab -->
    <div class="tab-pane fade" id="customers" role="tabpanel" aria-labelledby="customers-tab">
      <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
        <h2>Customers</h2>
        <a href="f8_customer_update.php" class="btn btn-primary">➕ Add New Customer</a>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover datatable" id="customerTable">
          <thead class="table-dark">
            <tr>
              <th>Customer ID</th>
              <th>Name</th>
              <th>Address</th>
              <th>City</th>
              <th>State</th>
              <th>Preferred Meat</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT * FROM Customer_T";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>".$row["Customer_ID"]."</td>
                    <td>".$row["Name"]."</td>
                    <td>".$row["Street"]."</td>
                    <td>".$row["City"]."</td>
                    <td>".$row["State"]."</td>
                    <td>".$row["Preferred_Meat_Type"]."</td>
                    <td>".$row["Contact_Number"]."</td>
                    <td>".$row["Email"]."</td>
                    <td>
                      <a href='f8_customer_update.php?edit=".$row["Customer_ID"]."' class='btn btn-sm btn-warning'>✏️ Edit</a>
                      <a href='customer_delete.php?id=".$row["Customer_ID"]."' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\")'>🗑️ Delete</a>
                    </td>
                  </tr>";
              }
            } else {
              echo "<tr><td colspan='9' class='text-center'>No customers found</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Top Lists Tab -->
    <div class="tab-pane fade" id="toplists" role="tabpanel" aria-labelledby="top-tab">
      <div class="top-list">
        <h3 class="mt-4">Top 5 Buyers</h3>
        <table class="table table-bordered table-striped">
          <thead class="table-dark">
            <tr><th>Name</th><th>City</th><th>Preferred Meat</th></tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT Name, City, Preferred_Meat_Type FROM Customer_T LIMIT 5";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()) {
              echo "<tr><td>".$row["Name"]."</td><td>".$row["City"]."</td><td>".$row["Preferred_Meat_Type"]."</td></tr>";
            }
            ?>
          </tbody>
        </table>

        <h3 class="mt-5">Top 5 Sellers</h3>
        <table class="table table-bordered table-striped">
          <thead class="table-dark">
            <tr><th>Name</th><th>City</th><th>Meat Type</th></tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT Name, City, Meat_Type_Sold FROM Vendor_T LIMIT 5";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()) {
              echo "<tr><td>".$row["Name"]."</td><td>".$row["City"]."</td><td>".$row["Meat_Type_Sold"]."</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<script>
$(document).ready(function() {
  $('.datatable').DataTable({
    pageLength: 5,
    dom: 'Bfrtip',
    buttons: ['csv', 'pdf']
  });
});
</script>

</body>
</html>
