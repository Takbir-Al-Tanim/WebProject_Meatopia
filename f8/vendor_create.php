<?php
include __DIR__ . '/db_connect.php';

$editMode = isset($_POST['editMode']) && $_POST['editMode'] == '1';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $vendorId = $_POST['Vendor_ID'];
    $vendorType = $_POST['Vendor_Type'];
    $name = $_POST['Name'];
    $street = $_POST['Street'];
    $city = $_POST['City'];
    $state = $_POST['State'];
    $meatTypeSold = $_POST['Meat_Type_Sold'];
    $contactInfo = $_POST['Contact_info'];
    $email = $_POST['Email'];

    if ($editMode) {
        // UPDATE
        $stmt = $conn->prepare("UPDATE Vendor_T SET Vendor_Type = ?, Name = ?, Street = ?, City = ?, State = ?, Meat_Type_Sold = ?, Contact_info = ?, Email = ? WHERE Vendor_ID = ?");
        $stmt->bind_param("sssssssss", $vendorType, $name, $street, $city, $state, $meatTypeSold, $contactInfo, $email, $vendorId);
        $stmt->execute();
        $stmt->close();
    } else {
        // INSERT
        $stmt = $conn->prepare("INSERT INTO Vendor_T (Vendor_ID, Vendor_Type, Name, Street, City, State, Meat_Type_Sold, Contact_info, Email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $vendorId, $vendorType, $name, $street, $city, $state, $meatTypeSold, $contactInfo, $email);
        $stmt->execute();
        $stmt->close();
    }

    $conn->close();

    // Redirect back to vendors tab
    header("Location: f8.php#vendors");
    exit();
}
?>
