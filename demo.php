<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer & Seller Directory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .search-bar {
            max-width: 400px;
        }
        .navbar {
            margin-bottom: 20px;
        }
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .table thead th {
            background-color: #212529;
            color: white;
        }
        .action-btn {
            padding: 5px 10px;
            margin-right: 5px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .edit-btn {
            background-color: #0d6efd;
            color: white;
        }
        .delete-btn {
            background-color: #dc3545;
            color: white;
        }
        .add-btn {
            background-color: #198754;
            color: white;
        }
        .modal-content {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px;
            border-radius: 4px;
            color: white;
            display: none;
            z-index: 1000;
        }
        .success {
            background-color: #198754;
        }
        .error {
            background-color: #dc3545;
        }
        .tab-content {
            background-color: white;
            border-radius: 0 0 5px 5px;
            padding: 20px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .nav-tabs .nav-link {
            border: 1px solid #dee2e6;
            border-bottom: none;
            border-radius: 5px 5px 0 0;
            margin-right: 5px;
            background-color: #e9ecef;
        }
        .nav-tabs .nav-link.active {
            background-color: white;
            border-bottom: 1px solid white;
            margin-bottom: -1px;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Buyer & Seller Directory</a>
        </div>
    </nav>

    <!-- Page Container -->
    <div class="container py-4">
        <!-- Tabs Navigation -->
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

        <!-- Tab Contents -->
        <div class="tab-content" id="directoryTabsContent">
            <!-- Farms Tab -->
            <div class="tab-pane fade show active" id="farms" role="tabpanel" aria-labelledby="farms-tab">
                <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
                    <input type="text" id="farmSearch" class="form-control search-bar" placeholder="Search farms...">
                    <button class="btn btn-success ms-3" onclick="openModal('farm')">+ Add New Farm</button>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Farm ID</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Type</th>
                                <th>Phone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="farmsTableBody">
                            <!-- Farm data will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Vendors Tab -->
            <div class="tab-pane fade" id="vendors" role="tabpanel" aria-labelledby="vendors-tab">
                <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
                    <input type="text" id="vendorSearch" class="form-control search-bar" placeholder="Search vendors...">
                    <button class="btn btn-success ms-3" onclick="openModal('vendor')">+ Add New Vendor</button>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0">
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
                        <tbody id="vendorsTableBody">
                            <!-- Vendor data will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Customers Tab -->
            <div class="tab-pane fade" id="customers" role="tabpanel" aria-labelledby="customers-tab">
                <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
                    <input type="text" id="customerSearch" class="form-control search-bar" placeholder="Search customers...">
                    <button class="btn btn-success ms-3" onclick="openModal('customer')">+ Add New Customer</button>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Customer ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Preferred Meat</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="customersTableBody">
                            <!-- Customer data will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal for Add/Edit -->
    <div id="formModal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add New Record</h5>
                    <button type="button" class="btn-close" onclick="closeModal()"></button>
                </div>
                <div class="modal-body">
                    <form id="dataForm">
                        <input type="hidden" id="recordId">
                        <input type="hidden" id="recordType">
                        
                        <div id="formFields">
                            <!-- Form fields will be dynamically added here -->
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveRecord()">Save</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Notification -->
    <div id="notification" class="notification"></div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // (Keep all your existing JavaScript code here)
        // The JavaScript from your previous implementation will work with this HTML structure
        // Just make sure to update any selectors if needed to match the new structure
    </script>
</body>
</html>