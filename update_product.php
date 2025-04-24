<?php
include __DIR__ . '/db_connect.php';

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['Product_ID'];
    $updatedData = $_POST['updatedData'];

    // Prepare the SQL query to update the product
    $sql = "UPDATE Product_T SET 
            Meat_Type = ?, 
            Country = ?, 
            Region = ?, 
            Seasonality = ?, 
            Certifications = ?, 
            Fat_Content = ?, 
            Grade = ?, 
            Cattle_ID = ? 
            WHERE Product_ID = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssssss", 
        $updatedData['Meat_Type'], 
        $updatedData['Country'], 
        $updatedData['Region'], 
        $updatedData['Seasonality'], 
        $updatedData['Certifications'], 
        $updatedData['Fat_Content'], 
        $updatedData['Grade'], 
        $updatedData['Cattle_ID'], 
        $product_id
    );

    // Execute the statement
    if ($stmt->execute()) {
        echo "Product updated successfully!";
    } else {
        echo "Failed to update product!";
    }

    $stmt->close();
    $conn->close();
}
?>
