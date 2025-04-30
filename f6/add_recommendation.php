<?php
include __DIR__ . '/db_connect.php';

// Initialize the variables for the form, in case of any validation or errors
$farmId = '';
$cattleId = '';
$recommendationText = '';

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recommendation_action']) && $_POST['recommendation_action'] === 'save') {
    // Get the form data
    $farmId = $_POST['farmId'];
    $cattleId = $_POST['cattleId'];
    $recommendationText = $_POST['recommendationText'];

    // Prepare the insert statement
    $stmt = $conn->prepare("INSERT INTO Recommendation_T (Farm_ID, Cattle_ID, Recommendation_Text) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $farmId, $cattleId, $recommendationText);

    // Execute and check if the insertion was successful
    if ($stmt->execute()) {
        header("Location: f6_read.php?msg=Recommendation added successfully");
        exit();
    } else {
        $errorMessage = "Error: " . $stmt->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Recommendation</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="text-center mb-4">Add Recommendation</h2>

    <div class="card p-4 shadow-sm">
      <!-- Display any error message -->
      <?php if (isset($errorMessage)): ?>
        <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
      <?php endif; ?>

      <form action="f6_update_recommendation.php" method="POST">
        <!-- Add hidden field to indicate insertion action -->
        <input type="hidden" name="recommendation_action" value="save">

        <div class="mb-3">
          <label class="form-label">Farm ID</label>
          <input type="text" class="form-control" name="farmId" value="<?php echo htmlspecialchars($farmId); ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Cattle ID</label>
          <input type="text" class="form-control" name="cattleId" value="<?php echo htmlspecialchars($cattleId); ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Recommendation</label>
          <textarea class="form-control" name="recommendationText" rows="3" required><?php echo htmlspecialchars($recommendationText); ?></textarea>
        </div>

        <button type="submit" class="btn btn-info">Submit Recommendation</button>
      </form>
    </div>
  </div>
</body>
</html>
