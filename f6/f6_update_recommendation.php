<?php
include __DIR__ . '/db_connect.php'; // Database connection

if (isset($_POST['recommendation_action'])) {
    $cattleId = $_POST['cattleId'];
    $farmId = $_POST['farmId'];
    $recommendationText = $_POST['recommendationText'];

    if ($_POST['recommendation_action'] === 'save') {
        // Only insert the Cattle_ID, Farm_ID, and Recommendation_Text. Let the database handle Recommendation_ID.
        $stmt = $conn->prepare("INSERT INTO Recommendation_T (Cattle_ID, Farm_ID, Recommendation_Text) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $cattleId, $farmId, $recommendationText);

        if ($stmt->execute()) {
            header("Location: f6_read.php?msg=Recommendation added successfully");
            exit();
        } else {
            echo "Insert Error: " . $stmt->error;
        }
    }

    if ($_POST['recommendation_action'] === 'update') {
        $recommendationId = $_POST['recommendationId']; // For update, we need the Recommendation_ID
        $stmt = $conn->prepare("UPDATE Recommendation_T SET Cattle_ID=?, Farm_ID=?, Recommendation_Text=? WHERE Recommendation_ID=?");
        $stmt->bind_param("ssss", $cattleId, $farmId, $recommendationText, $recommendationId);

        if ($stmt->execute()) {
            header("Location: f6_read.php?msg=Recommendation updated successfully");
            exit();
        } else {
            echo "Update Error: " . $stmt->error;
        }
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
