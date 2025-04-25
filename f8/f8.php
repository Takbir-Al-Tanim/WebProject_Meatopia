<?php 
include __DIR__ . '/db_connect.php';  // Database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Buyer & Seller Directory</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Full viewport height and width */
    body {
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
        width: 100vw;  /* Full width of the viewport */
        height: 100vh; /* Full height of the viewport */
        display: flex;
        flex-direction: column;
    }

    /* Table container to take up full height minus header and other elements */
    .table-container {
        margin-top: 30px;
        width: 100%;
        flex-grow: 1; /* Expands to take remaining space */
        padding-bottom: 30px;  /* Optional: Adds padding at the bottom */
        overflow-y: auto; /* Ensures the content can scroll if it's too long */
    }

    /* Search input adjustment */
    .search-input {
        max-width: 300px;
        width: 100%;
    }

    /* Navbar styling to ensure it stays at the top */
    nav.navbar {
        z-index: 1000;
    }

    /* Optional: To manage padding for tab content */
    .tab-content {
        padding-top: 20px;
    }

    /* Adjustments for table columns */
    table th, table td {
        white-space: nowrap; /* Prevent text from wrapping */
    }

    table th:nth-child(1),
    table td:nth-child(1) {
        width: 10%; /* Adjust for smaller columns */
    }

    table th:nth-child(2),
    table td:nth-child(2) {
        width: 15%;
    }

    table th:nth-child(3),
    table td:nth-child(3) {
        width: 20%;
    }

    /* Optional: Makes sure tables look better when the sidebar is collapsed */
    .table-responsive {
        margin-left: 0;
    }
</style>

</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Buyer & Seller Directory</a>
    </div>
  </nav>

  <!-- Main Content -->
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
    </ul>

    <div class="tab-content" id="directoryTabsContent">
        <!-- Farms Tab -->
        <div class="tab-pane fade show active" id="farms" role="tabpanel" aria-labelledby="farms-tab">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Farms</h2>
                <a href="f8_farm_update.php" class="btn btn-primary">➕ Add New Farm</a>
            </div>
            
            <div class="input-group mb-4" style="max-width: 400px;">
                <span class="input-group-text bg-primary text-white">🔍</span>
                <input type="text" class="form-control" id="farmSearchInput" placeholder="Search farms..." aria-label="Search">
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="farmTable">
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
                        $sql = "SELECT * FROM Farm_T";  // Load farms from the Farm_T table
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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Vendors</h2>
                <a href="f8_vendor_update.php" class="btn btn-primary">➕ Add New Vendor</a>
            </div>
            
            <div class="input-group mb-4" style="max-width: 400px;">
                <span class="input-group-text bg-primary text-white">🔍</span>
                <input type="text" class="form-control" id="vendorSearchInput" placeholder="Search vendors..." aria-label="Search">
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="vendorTable">
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
                        $sql = "SELECT * FROM Vendor_T";  // Load vendors from the Vendor_T table
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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Customers</h2>
                <a href="f8_customer_update.php" class="btn btn-primary">➕ Add New Customer</a>
            </div>
            
            <div class="input-group mb-4" style="max-width: 400px;">
                <span class="input-group-text bg-primary text-white">🔍</span>
                <input type="text" class="form-control" id="customerSearchInput" placeholder="Search customers..." aria-label="Search">
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="customerTable">
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
                        $sql = "SELECT * FROM Customer_T";  // Load customers from the Customer_T table
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
    </div>
  </div>

  <!-- Add Bootstrap JS and Popper -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

</body>
</html>
