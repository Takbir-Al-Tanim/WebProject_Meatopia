<?php
include __DIR__ . '/db_connect.php';

// Initialize customer data
$customerData = [
    'Customer_ID' => '',
    'Name' => '',
    'Street' => '',
    'City' => '',
    'State' => '',
    'Preferred_Meat_Type' => '',
    'Contact_Number' => '',
    'Email' => ''
];

$editMode = false;

// Check if we are in edit mode
if (isset($_POST['editMode']) && $_POST['editMode'] == '1') {
    // Editing an existing customer
    $editMode = true;
    $customerData = [
        'Customer_ID' => $_POST['Customer_ID'],
        'Name' => $_POST['Name'],
        'Street' => $_POST['Street'],
        'City' => $_POST['City'],
        'State' => $_POST['State'],
        'Preferred_Meat_Type' => $_POST['Preferred_Meat_Type'],
        'Contact_Number' => $_POST['Contact_Number'],
        'Email' => $_POST['Email']
    ];

    // Prepare the SQL statement to update the customer
    $stmt = $conn->prepare("UPDATE Customer_T SET Name = ?, Street = ?, City = ?, State = ?, Preferred_Meat_Type = ?, Contact_Number = ?, Email = ? WHERE Customer_ID = ?");
    $stmt->bind_param("ssssssss", $customerData['Name'], $customerData['Street'], $customerData['City'], $customerData['State'], $customerData['Preferred_Meat_Type'], $customerData['Contact_Number'], $customerData['Email'], $customerData['Customer_ID']);
    $stmt->execute();
    $stmt->close();

    // Redirect to the customer list page after updating
    header("Location: f8.php#customers");
    exit();

} else {
    // Adding a new customer
    if (isset($_POST['Customer_ID'])) {
        // Gather customer data from the form
        $customerData = [
            'Customer_ID' => $_POST['Customer_ID'],
            'Name' => $_POST['Name'],
            'Street' => $_POST['Street'],
            'City' => $_POST['City'],
            'State' => $_POST['State'],
            'Preferred_Meat_Type' => $_POST['Preferred_Meat_Type'],
            'Contact_Number' => $_POST['Contact_Number'],
            'Email' => $_POST['Email']
        ];

        // Prepare the SQL statement to insert the new customer
        $stmt = $conn->prepare("INSERT INTO Customer_T (Customer_ID, Name, Street, City, State, Preferred_Meat_Type, Contact_Number, Email) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $customerData['Customer_ID'], $customerData['Name'], $customerData['Street'], $customerData['City'], $customerData['State'], $customerData['Preferred_Meat_Type'], $customerData['Contact_Number'], $customerData['Email']);
        $stmt->execute();
        $stmt->close();

        // Redirect to the customer list page after adding
        header("Location: f8.php#customers");
        exit();
    }
}

$conn->close();
?>
