<?php
include __DIR__ . '/db_connect.php'; // Include DB connection

// Initialize variables for form input
$recommendationId = '';
$farmId = '';
$cattleId = '';
$recommendationText = '';

// Check if a recommendation ID is passed in the URL (for editing)
if (isset($_GET['recommendation_id'])) {
    $recommendationId = $_GET['recommendation_id'];

    // Fetch the existing data from the database for the given Recommendation_ID
    $stmt = $conn->prepare("SELECT * FROM Recommendation_T WHERE Recommendation_ID = ?");
    $stmt->bind_param("s", $recommendationId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $farmId = $row['Farm_ID'];
        $cattleId = $row['Cattle_ID'];
        $recommendationText = $row['Recommendation_Text'];
    } else {
        echo "Recommendation not found!";
        exit();
    }
}

// Handle form submission to update the recommendation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recommendation_action']) && $_POST['recommendation_action'] === 'update') {
    // Get the form data
    $farmId = $_POST['farmId'];
    $cattleId = $_POST['cattleId'];
    $recommendationText = $_POST['recommendationText'];

    // Prepare the update statement
    $stmt = $conn->prepare("UPDATE Recommendation_T SET Farm_ID = ?, Cattle_ID = ?, Recommendation_Text = ? WHERE Recommendation_ID = ?");
    $stmt->bind_param("ssss", $farmId, $cattleId, $recommendationText, $recommendationId);

    // Execute the update and check if it was successful
    if ($stmt->execute()) {
        header("Location: f6_read.php?msg=Recommendation updated successfully");
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
  <title>Edit Recommendation</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="text-center mb-4">Edit Recommendation</h2>

    <div class="card p-4 shadow-sm">
      <!-- Display any error message -->
      <?php if (isset($errorMessage)): ?>
        <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
      <?php endif; ?>

      <form action="f6_edit_recommendation.php?recommendation_id=<?php echo htmlspecialchars($recommendationId); ?>" method="POST">
        <!-- Add hidden field to indicate the update action -->
        <input type="hidden" name="recommendation_action" value="update">

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

        <button type="submit" class="btn btn-info">Update Recommendation</button>
      </form>
    </div>
  </div>
</body>
</html>
