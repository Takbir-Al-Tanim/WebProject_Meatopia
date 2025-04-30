<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Meatopia Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      background-color: #f8f9fa;
      transition: margin-left 0.3s;
    }
    .sidebar {
      width: 250px;
      height: 100vh;
      background: #222425;
      color: white;
      position: fixed;
      padding: 20px;
      transition: width 0.3s;
      overflow: hidden;
      z-index: 1000;
    }
    .sidebar.collapsed {
      width: 70px;
    }
    .sidebar h4 {
      text-align: center;
      margin-bottom: 30px;
      white-space: nowrap;
    }
    .sidebar.collapsed h4 {
      display: none;
    }
    .sidebar .admin {
      font-size: 1.2rem;
      margin-bottom: 20px;
      text-align: center;
      color: #adb5bd;
      white-space: nowrap;
    }
    .sidebar.collapsed .admin {
      font-size: 1.5rem;
      margin-bottom: 30px;
    }
    .sidebar a {
      color: white;
      text-decoration: none;
      display: block;
      padding: 12px;
      margin: 10px 0;
      transition: 0.3s;
      font-size: 1rem;
      white-space: nowrap;
    }
    .sidebar.collapsed a {
      text-align: center;
      padding: 12px 5px;
    }
    .sidebar a span {
      margin-left: 10px;
    }
    .sidebar.collapsed a span {
      display: none;
    }
    .sidebar a:hover {
      background: #0d6efd;
      border-radius: 5px;
    }
    .sidebar a.active {
      background-color: #0d6efd;
      color: white;
      border-radius: 5px;
    }
    .main-content {
      margin-left: 270px;
      padding: 20px;
      transition: margin-left 0.3s;
    }
    .sidebar.collapsed ~ .main-content {
      margin-left: 90px;
    }
    .topbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }
    .topbar .search-bar input {
      width: 300px;
    }
    .btn {
      background: none;
      border: none;
      font-weight: 500;
    }
    .btn:hover {
      color: #0d6efd;
    }
    .dropdown-menu {
      font-size: 0.9rem;
    }
    #contentFrame {
      width: 100%;
      height: 800px;
      border: none;
    }
    .toggle-sidebar {
      position: fixed;
      left: 10px;
      top: 10px;
      z-index: 1100;
      background: #222425;
      color: white;
      border: none;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: left 0.3s;
    }
    .sidebar.collapsed ~ .toggle-sidebar {
      left: 80px;
    }
    .btn-secondary {
      color: black;
      font-size: 1.1rem;
    }
    .btn-secondary:hover {
      color: #0d6efd;
    }
    .dropdown-menu-end {
      color: black;
    }
    .dropdown-item {
      color: black;
      font-size: 1.1rem;
    }
    .dropdown-item:hover {
      background-color: #f8f9fa;
    }
  </style>
</head>
<body>

  <!-- Toggle Sidebar Button -->
  <button class="toggle-sidebar" onclick="toggleSidebar()">
    <i class="bi bi-list"></i>
  </button>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <h4>Meatopia.com</h4>
    <div class="admin">👤 Admin</div>
    <a href="#" onclick="changeContent('overview')"><i class="bi bi-bar-chart-line"></i><span>Dashboard Overview</span></a>
    <a href="#" onclick="changeContent('productInfo')"><i class="bi bi-box-seam"></i><span>Product Info</span></a>
    <a href="#" onclick="changeContent('productionData')"><i class="bi bi-file-earmark-text"></i><span>Production Data</span></a>
    <a href="#" onclick="changeContent('consumerDemand')"><i class="bi bi-people"></i><span>Consumer Demand</span></a>
    <a href="#" onclick="changeContent('realTimeSupply')"><i class="bi bi-truck"></i><span>Supply & Logistics</span></a>
    <a href="#" onclick="changeContent('marketPrices')"><i class="bi bi-graph-up"></i><span>Market Trends</span></a>
    <a href="#" onclick="changeContent('recommendations')"><i class="bi bi-egg"></i><span>Farm & Livestock</span></a>
    <a href="#" onclick="changeContent('directory')"><i class="bi bi-telephone"></i><span>Buyer & Seller</span></a>
    <a href="#" onclick="changeContent('historicalGraph')"><i class="bi bi-graph-up-arrow"></i><span>Historical Graph</span></a>
    <a href="#" onclick="changeContent('currentGraph')"><i class="bi bi-bar-chart"></i><span>Current Graph</span></a>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="topbar">
      <div class="search-bar">
        <input type="text" class="form-control" placeholder="Search..." />
      </div>
      <div class="d-flex align-items-center gap-3">
        <!-- Message Dropdown -->
        <div class="dropdown">
          <button class="btn btn-secondary d-flex align-items-center gap-1" type="button" id="messageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-envelope-fill"></i>
            <span>Message</span>
            <i class="bi bi-caret-down-fill"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="messageDropdown">
            <li><strong>Messages</strong></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Send a Message</a></li>
            <li><a class="dropdown-item" href="#">View Inbox</a></li>
          </ul>
        </div>

        <!-- Notification Dropdown -->
        <div class="dropdown">
          <button class="btn btn-secondary d-flex align-items-center gap-1" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-bell-fill"></i>
            <span>Notification</span>
            <i class="bi bi-caret-down-fill"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="notificationDropdown">
            <li><strong>Notifications</strong></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">No new alerts</a></li>
          </ul>
        </div>

        <!-- Profile Dropdown -->
        <div class="dropdown">
          <button class="btn btn-secondary d-flex align-items-center gap-1" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://via.placeholder.com/30" class="rounded-circle" alt="Profile" width="30" height="30">
            <span>TANIM</span>
            <i class="bi bi-caret-down-fill"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="profileDropdown">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Logout</a></li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Content Area -->
    <div id="contentArea">
      <!-- Always Show Historical and Current Graphs -->
      <div id="graphsContainer">
        <div id="historicalGraphContainer" style="display:none;">
          <!-- Historical Graph will load here -->
        </div>
        <div id="currentGraphContainer" style="display:none;">
          <!-- Current Graph will load here -->
        </div>
      </div>
    </div>
  </div>

  <!-- Script -->
  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('collapsed');
    }

    function changeContent(contentType) {
      const historicalGraphContainer = document.getElementById('historicalGraphContainer');
      const currentGraphContainer = document.getElementById('currentGraphContainer');

      historicalGraphContainer.style.display = 'none';
      currentGraphContainer.style.display = 'none';

      let file = '';
      switch (contentType) {
        case 'overview':
          file = 'o.html'; break;
        case 'productInfo':
          file = 'f1.php'; break;
        case 'productionData':
          file = 'ProductionData/index.php'; break;
        case 'consumerDemand':
          file = 'f3.html'; break;
        case 'realTimeSupply':
          file = 'f4.html'; break;
        case 'marketPrices':
          file = 'f5/read.php'; break;
        case 'recommendations':
          file = 'f6.html'; break;
        case 'directory':
          file = 'f8/f8.php'; break;
        case 'historicalGraph':
          historicalGraphContainer.style.display = 'block';
          file = 'historical_graph.php';
          break;
        case 'currentGraph':
          currentGraphContainer.style.display = 'block';
          file = 'current_graph.php';
          break;
        default:
          file = '';
      }

      if (file) {
        loadGraph(contentType);
      }
    }

    function loadGraph(type) {
      const historicalGraphContainer = document.getElementById('historicalGraphContainer');
      const currentGraphContainer = document.getElementById('currentGraphContainer');
      if (type === 'historicalGraph') {
        fetch('historical_graph.php')
          .then(response => response.text())
          .then(html => {
            historicalGraphContainer.innerHTML = html;
          });
      }
      if (type === 'currentGraph') {
        fetch('current_graph.php')
          .then(response => response.text())
          .then(html => {
            currentGraphContainer.innerHTML = html;
          });
      }
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
