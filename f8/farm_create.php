<?php
include __DIR__ . '/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form values
    $farmId = $_POST['Farm_ID'];
    $name = $_POST['Name'];
    $street = $_POST['Street'];
    $city = $_POST['City'];
    $state = $_POST['State'];
    $certification = $_POST['Certification'] ?? ''; // Optional field
    $contactNumber = $_POST['ContactNumber'];
    $email = $_POST['Email'];

    // Check if we're in "edit" mode (if we have a Farm_ID in the URL)
    if (isset($_POST['editMode']) && $_POST['editMode'] == '1') {
        // Edit mode: Update an existing farm
        $stmt = $conn->prepare("UPDATE Farm_T SET Name = ?, Street = ?, City = ?, State = ?, Certification = ?, ContactNumber = ?, Email = ? WHERE Farm_ID = ?");
        $stmt->bind_param("ssssssss", $name, $street, $city, $state, $certification, $contactNumber, $email, $farmId);
        $stmt->execute();
        $stmt->close();
        header("Location: f8.php#farms"); // Redirect after update
    } else {
        // Add new farm
        $stmt = $conn->prepare("INSERT INTO Farm_T (Farm_ID, Name, Street, City, State, Certification, ContactNumber, Email) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $farmId, $name, $street, $city, $state, $certification, $contactNumber, $email);
        $stmt->execute();
        $stmt->close();
        header("Location: f8.php#farms"); // Redirect after insertion
    }

    $conn->close();
    exit;
}
?>
