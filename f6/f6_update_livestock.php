<?php
include __DIR__ . '/db_connect.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['cattle_action'];

    $cattleId = $_POST['cattleId'];
    $breed = $_POST['breed'];
    $weight = $_POST['weight'];
    $age = $_POST['age'];
    $health = $_POST['health'];
    $farmId = $_POST['farmId'];

    if ($action === 'save') {
        // === INSERT operation ===
        $stmt = $conn->prepare("INSERT INTO Cattle_T (Cattle_ID, Breed, Weight, Age, Health, Farm_ID) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdiis", $cattleId, $breed, $weight, $age, $health, $farmId);

        if ($stmt->execute()) {
            header("Location: f6_read.php?msg=Cattle record added successfully");
            exit();
        } else {
            echo "Insert Error: " . $stmt->error;
        }

    } elseif ($action === 'update') {
        // === UPDATE operation ===
        $originalId = $_POST['original_cattle_id'];

        $stmt = $conn->prepare("UPDATE Cattle_T SET Cattle_ID=?, Breed=?, Weight=?, Age=?, Health=?, Farm_ID=? WHERE Cattle_ID=?");
        // Corrected binding: Health is a string, not an integer
        $stmt->bind_param("ssdisss", $cattleId, $breed, $weight, $age, $health, $farmId, $originalId);

        if ($stmt->execute()) {
            header("Location: f6_read.php?msg=Cattle record updated successfully");
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
