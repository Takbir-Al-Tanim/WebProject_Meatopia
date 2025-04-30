<?php
include __DIR__ . '/db_connect.php'; // Your DB connection file

// Initialize variables for form inputs
$delivery_id = $delivery_date = $street = $city = $state = $zip = $warehouse_id = $order_id = "";
$delivery_date_err = $street_err = $city_err = $state_err = $zip_err = $warehouse_id_err = $order_id_err = $delivery_id_err = "";

// Process the form when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate the inputs
    if (empty($_POST["delivery_id"])) {
        $delivery_id_err = "Delivery ID is required.";
    } else {
        $delivery_id = $_POST["delivery_id"];
    }

    if (empty($_POST["delivery_date"])) {
        $delivery_date_err = "Delivery date is required.";
    } else {
        $delivery_date = $_POST["delivery_date"];
    }

    if (empty($_POST["street"])) {
        $street_err = "Street is required.";
    } else {
        $street = $_POST["street"];
    }

    if (empty($_POST["city"])) {
        $city_err = "City is required.";
    } else {
        $city = $_POST["city"];
    }

    if (empty($_POST["state"])) {
        $state_err = "State is required.";
    } else {
        $state = $_POST["state"];
    }

    if (empty($_POST["zip"])) {
        $zip_err = "Zip code is required.";
    } else {
        $zip = $_POST["zip"];
    }

    if (empty($_POST["warehouse_id"])) {
        $warehouse_id_err = "Warehouse ID is required.";
    } else {
        $warehouse_id = $_POST["warehouse_id"];
    }

    if (empty($_POST["order_id"])) {
        $order_id_err = "Order ID is required.";
    } else {
        $order_id = $_POST["order_id"];
    }

    // If no errors, proceed with inserting data into the database
    if (empty($delivery_id_err) && empty($delivery_date_err) && empty($street_err) && empty($city_err) && empty($state_err) && empty($zip_err) && empty($warehouse_id_err) && empty($order_id_err)) {

        // Prepare the SQL statement to insert the data
        $sql = "INSERT INTO Delivery_T (Delivery_ID, Delivery_Date, Street, City, State, Zip, Warehouse_ID, Order_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Use prepared statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssi", $delivery_id, $delivery_date, $street, $city, $state, $zip, $warehouse_id, $order_id);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect to the warehouse list page after successful insert
            header("Location: f4_read.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Delivery Entry</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .error { color: red; }
  </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Supply Chain Dashboard</a>
  </div>
</nav>

<div class="container">
  <h2 class="mb-4">Add New Delivery Entry</h2>

  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="mb-3">
      <label for="delivery_id" class="form-label">Delivery ID</label>
      <input type="text" class="form-control" id="delivery_id" name="delivery_id" value="<?php echo $delivery_id; ?>">
      <span class="error"><?php echo $delivery_id_err; ?></span>
    </div>

    <div class="mb-3">
      <label for="delivery_date" class="form-label">Delivery Date</label>
      <input type="date" class="form-control" id="delivery_date" name="delivery_date" value="<?php echo $delivery_date; ?>">
      <span class="error"><?php echo $delivery_date_err; ?></span>
    </div>

    <div class="mb-3">
      <label for="street" class="form-label">Street</label>
      <input type="text" class="form-control" id="street" name="street" value="<?php echo $street; ?>">
      <span class="error"><?php echo $street_err; ?></span>
    </div>

    <div class="mb-3">
      <label for="city" class="form-label">City</label>
      <input type="text" class="form-control" id="city" name="city" value="<?php echo $city; ?>">
      <span class="error"><?php echo $city_err; ?></span>
    </div>

    <div class="mb-3">
      <label for="state" class="form-label">State</label>
      <input type="text" class="form-control" id="state" name="state" value="<?php echo $state; ?>">
      <span class="error"><?php echo $state_err; ?></span>
    </div>

    <div class="mb-3">
      <label for="zip" class="form-label">Zip Code</label>
      <input type="text" class="form-control" id="zip" name="zip" value="<?php echo $zip; ?>">
      <span class="error"><?php echo $zip_err; ?></span>
    </div>

    <div class="mb-3">
      <label for="warehouse_id" class="form-label">Warehouse ID</label>
      <input type="text" class="form-control" id="warehouse_id" name="warehouse_id" value="<?php echo $warehouse_id; ?>">
      <span class="error"><?php echo $warehouse_id_err; ?></span>
    </div>

    <div class="mb-3">
      <label for="order_id" class="form-label">Order ID</label>
      <input type="text" class="form-control" id="order_id" name="order_id" value="<?php echo $order_id; ?>">
      <span class="error"><?php echo $order_id_err; ?></span>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="f4_read.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>

</body>
</html>
