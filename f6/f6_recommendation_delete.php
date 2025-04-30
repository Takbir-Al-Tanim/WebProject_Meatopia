<?php
include __DIR__ . '/db_connect.php';

if ($_GET['type'] === 'recommendation' && isset($_GET['recommendation_id'])) {
    $recommendationId = $_GET['recommendation_id'];

    $stmt = $conn->prepare("DELETE FROM Recommendation_T WHERE Recommendation_ID = ?");
    $stmt->bind_param("s", $recommendationId);

    if ($stmt->execute()) {
        header("Location: f6_read.php?msg=Recommendation deleted successfully");
        exit();
    } else {
        echo "Error deleting recommendation: " . $stmt->error;
    }
} elseif ($_GET['type'] === 'info' && isset($_GET['cattle_id'])) {
    $cattleId = $_GET['cattle_id'];

    $stmt = $conn->prepare("DELETE FROM Cattle_T WHERE Cattle_ID = ?");
    $stmt->bind_param("s", $cattleId);

    if ($stmt->execute()) {
        header("Location: f6_read.php?msg=Livestock record deleted successfully");
        exit();
    } else {
        echo "Error deleting cattle: " . $stmt->error;
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
