<?php
include __DIR__ . '/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $product_id = $_POST['Product_ID'];
    $meat_type = $conn->real_escape_string($_POST['Meat_Type']);
    $country = $conn->real_escape_string($_POST['Country']);
    $region = $conn->real_escape_string($_POST['Region']);
    $seasonality = $conn->real_escape_string($_POST['Seasonality']);
    $certifications = $conn->real_escape_string($_POST['Certifications']);
    $fat_content = $conn->real_escape_string($_POST['Fat_Content']);
    $grade = $conn->real_escape_string($_POST['Grade']);
    $cattle_id = $conn->real_escape_string($_POST['Cattle_ID']);

    // Check if this is an update or insert
    if (!empty($product_id)) {
        // Update existing record
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
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssss", 
            $meat_type, $country, $region, $seasonality,
            $certifications, $fat_content, $grade, $cattle_id,
            $product_id);
    } else {
        // Insert new record
        $product_id = 'PRD' . uniqid();
        $sql = "INSERT INTO Product_T 
                (Product_ID, Meat_Type, Country, Region, Seasonality, 
                 Certifications, Fat_Content, Grade, Cattle_ID) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssss",
            $product_id, $meat_type, $country, $region, $seasonality,
            $certifications, $fat_content, $grade, $cattle_id);
    }

    // Execute the statement
    if ($stmt->execute()) {
        header("Location: f1.php?success=1");
        exit();
    } else {
        die("Error: " . $stmt->error);
    }
    
    $stmt->close();
}

$conn->close();
?>