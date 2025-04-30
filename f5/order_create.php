<?php
include __DIR__ . '/db_connect.php';

$orderData = [
    'Order_ID' => '',
    'Order_Date' => '',
    'Meat_Type' => '',
    'Quantity' => '',
    'Unit_Price' => '',
    'Customer_ID' => ''
];

$editMode = false;

if (isset($_POST['editMode']) && $_POST['editMode'] == '1') {
    $editMode = true;
    $orderData = [
        'Order_ID' => $_POST['Order_ID'],
        'Order_Date' => $_POST['order_date'],
        'Meat_Type' => $_POST['meat_type'],
        'Quantity' => $_POST['quantity'],
        'Unit_Price' => $_POST['unit_price'],
        'Customer_ID' => $_POST['customer_id']
    ];

    $stmt = $conn->prepare("UPDATE Order_T SET Order_Date = ?, Meat_Type = ?, Quantity = ?, Unit_Price = ?, Customer_ID = ? WHERE Order_ID = ?");
    $stmt->bind_param("ssddsi", $orderData['Order_Date'], $orderData['Meat_Type'], $orderData['Quantity'], $orderData['Unit_Price'], $orderData['Customer_ID'], $orderData['Order_ID']);
    $stmt->execute();
    $stmt->close();

    header("Location: read.php");
    exit();
} else {
    if (isset($_POST['order_date'])) {
        $orderData = [
            'Order_Date' => $_POST['order_date'],
            'Meat_Type' => $_POST['meat_type'],
            'Quantity' => $_POST['quantity'],
            'Unit_Price' => $_POST['unit_price'],
            'Customer_ID' => $_POST['customer_id']
        ];

        $stmt = $conn->prepare("INSERT INTO Order_T (Order_Date, Meat_Type, Quantity, Unit_Price, Customer_ID) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssddi", $orderData['Order_Date'], $orderData['Meat_Type'], $orderData['Quantity'], $orderData['Unit_Price'], $orderData['Customer_ID']);
        $stmt->execute();
        $stmt->close();

        header("Location: read.php");
        exit();
    }
}

$conn->close();
?>
