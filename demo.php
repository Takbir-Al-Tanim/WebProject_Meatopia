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
      background-color: #f4eee9; /* warm cream */  
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;  
      color: #3a2120; /* dark brown text */  
    }  

    .sidebar {  
      width: 250px;  
      height: 100vh;  
      background: #5b2221; /* deep burgundy */  
      color: #f4eee9; /* creamy light */  
      position: fixed;  
      padding: 20px;  
      box-shadow: 3px 0 10px rgba(0, 0, 0, 0.3);  
    }  

    .sidebar h4 {  
      text-align: center;  
      margin-bottom: 30px;  
      font-weight: 700;  
      font-size: 1.8rem;  
      letter-spacing: 1.5px;  
      color: #f6d5c3; /* soft beige */  
    }  

    .sidebar .admin {  
      font-size: 1.2rem;  
      margin-bottom: 20px;  
      text-align: center;  
      color: #ddb7a0;  
    }  

    .sidebar a {  
      color: #f4eee9;  
      text-decoration: none;  
      display: block;  
      padding: 12px;  
      margin: 10px 0;  
      transition: background-color 0.3s ease, color 0.3s ease;  
      font-size: 1.1rem;  
      border-radius: 5px;  
    }  

    .sidebar a:hover,  
    .sidebar a.active {  
      background: #a73e35; /* warm tomato red */  
      color: #fff3e4;  
      font-weight: 600;  
      box-shadow: 0 0 10px #a73e35;  
    }  

    .main-content {  
      margin-left: 260px;  
      padding: 20px;  
      background: #fff8f5; /* almost white warm */  
      min-height: 100vh;  
    }  

    .topbar {  
      display: flex;  
      justify-content: space-between;  
      align-items: center;  
      margin-bottom: 30px;  
      background: #edd7ca; /* soft beige */  
      padding: 12px 20px;  
      border-radius: 10px;  
      box-shadow: 0 4px 12px rgba(183, 52, 48, 0.2);  
    }  

    .topbar .search-bar input {  
      width: 300px;  
      border: 1.5px solid #a73e35;  
      border-radius: 20px;  
      padding: 6px 12px;  
      font-size: 1rem;  
      color: #3a2120;  
      background: #fff3e4;  
      transition: border-color 0.3s ease;  
    }  

    .topbar .search-bar input:focus {  
      outline: none;  
      border-color: #5b2221;  
      background: #f6d5c3;  
    }  

    .btn {  
      background: none;  
      border: none;  
      font-weight: 600;  
      color: #5b2221;  
      font-size: 1.1rem;  
    }  

    .btn:hover {  
      color: #a73e35;  
    }  

    .dropdown-menu {  
      font-size: 1rem;  
      background: #f7ede7;  
      border: 1.5px solid #a73e35;  
      border-radius: 10px;  
      color: #3a2120;  
    }  

    .dropdown-menu .dropdown-item {  
      color: #5b2221;  
      font-weight: 500;  
      font-size: 1rem;  
    }  

    .dropdown-menu .dropdown-item:hover {  
      background-color: #ffd6ca;  
      color: #800000;  
    }  

    #contentFrame {  
      width: 100%;  
      height: 800px;  
      border: none;  
      border-radius: 12px;  
      box-shadow: 0 4px 15px rgba(167, 62, 53, 0.3);  
      background: white;  
    }  
  </style>  
</head>  
<body>  

  <!-- Sidebar -->  
  <div class="sidebar">  
    <h4>Meatopia.com</h4>  
    <div class="admin">👤 Admin</div>  
    <a href="#" onclick="changeContent('overview')">📊 Dashboard Overview</a>  
    <a href="#" onclick="changeContent('productInfo')">📦 Product Info</a>  
    <a href="#" onclick="changeContent('productionData')">📜 Production Data</a>  
    <a href="#" onclick="changeContent('consumerDemand')">👥 Consumer Demand</a>  
    <a href="#" onclick="changeContent('realTimeSupply')">🚚 Supply & Logistics</a>  
    <a href="#" onclick="changeContent('marketPrices')">📈 Market Trends</a>  
    <a href="#" onclick="changeContent('recommendations')">🐄 Farm & Livestock</a>  
    <a href="#" onclick="changeContent('directory')">📞 Buyer & Seller</a>  
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

    <!-- Content Area with iframe -->  
    <div id="contentArea">  
      <iframe id="contentFrame" src="o.html"></iframe>  
    </div>  
  </div>  

  <!-- Script -->  
  <script>  
    function changeContent(contentType) {  
      const iframe = document.getElementById('contentFrame');  
      let file = '';  

      switch (contentType) {  
        case 'overview': file = 'o.html'; break;  
        case 'productInfo': file = 'f1.php'; break;  
        case 'productionData': file = 'f2.html'; break;  
        case 'consumerDemand': file = 'f3.html'; break;  
        case 'realTimeSupply': file = 'f4.html'; break;  
        case 'marketPrices': file = 'f5.html'; break;  
        case 'analytics': file = 'f7.html'; break;  
        case 'recommendations': file = 'f6.html'; break;  
        case 'directory': file = 'f8.html'; break;  
        default:  
          iframe.srcdoc = '<h3>Welcome to Meatopia Dashboard</h3><p>Select an option from the sidebar.</p>';  
          return;  
      }  

      iframe.src = file;  
    }  

    window.addEventListener('DOMContentLoaded', () => {  
      changeContent('overview');  
    });  

    document.querySelectorAll('.sidebar a').forEach(link => {  
      link.addEventListener('click', function () {  
        document.querySelectorAll('.sidebar a').forEach(l => l.classList.remove('active'));  
        this.classList.add('active');  
      });  
    });  
  </script>  

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>  
</body>  
</html>  