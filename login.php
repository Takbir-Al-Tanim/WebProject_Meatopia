<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Meatopia</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f1f3f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-card {
      background: white;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }

    .login-card h2 {
      margin-bottom: 25px;
      text-align: center;
      font-weight: 600;
      color: #343a40;
    }

    .form-control {
      border-radius: 10px;
    }

    .btn-login {
      border-radius: 10px;
      background-color: #0d6efd;
      color: white;
    }

    .btn-login:hover {
      background-color: #0b5ed7;
    }

    .form-text {
      text-align: center;
      margin-top: 15px;
    }
  </style>
</head>
<body>

  <div class="login-card">
    <h2>Meatopia.com</h2>
    <form id="loginForm">
        <div class="mb-3">
          <label for="userid" class="form-label">User ID</label>
          <input type="text" class="form-control" id="userid" name="userid" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <!-- Dropdown for User Role Selection -->
        <div class="mb-3">
          <label for="userRole" class="form-label">Select Role</label>
          <select class="form-select" id="userRole" name="userRole" required>
            <option value="">Choose User Role</option>
            <option value="wholesaler">Wholesaler</option>
            <option value="butcher">Butcher</option>
            <option value="cold_storage">Cold Storage Provider</option>
            <option value="customer">Customer</option>
            <option value="admin">Admin</option> <!-- Added admin role -->
          </select>
        </div>

        <button type="submit" class="btn btn-login w-100 mt-3">Login</button>
        <div class="form-text">
          Don't have an account? <a href="#">Register</a>
        </div>
    </form>
  </div>

  <script>
    // Add event listener to the form
    document.getElementById("loginForm").addEventListener("submit", function(event) {
      event.preventDefault(); // Prevent the default form submission

      // Get the values of user ID, password, and user role
      const userId = document.getElementById("userid").value;
      const password = document.getElementById("password").value;
      const userRole = document.getElementById("userRole").value;

      // Check if the entered credentials are correct and a role is selected
      if (userId === "2331694" && password === "1234" && userRole !== "") {
        // Redirect based on the selected user role
        if (userRole === "wholesaler") {
          window.location.href = "f3.html"; // Redirect to wholesalers page
        } else if (userRole === "butcher") {
          window.location.href = "ProductionData/view_slaughterhouse.php"; // Redirect to butchers page
        } else if (userRole === "cold_storage") {
          window.location.href = "f4/f4_read.php"; // Redirect to cold storage page
        } else if (userRole === "customer") {
          window.location.href = "f5/read.php"; // Redirect to customer page
        } else if (userRole === "admin") {
          window.location.href = "dashboard.php"; // Redirect to admin dashboard
        }
      } else {
        // Show an alert if credentials or role are incorrect
        alert("Invalid User ID, Password, or Role. Please try again.");
      }
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
