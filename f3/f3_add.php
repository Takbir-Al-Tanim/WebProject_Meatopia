<?php 
include __DIR__ . '/db_connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data (VERY IMPORTANT!)
    $nutritionId = mysqli_real_escape_string($conn, $_POST["nutritionId"]);
    $year = mysqli_real_escape_string($conn, $_POST["year"]);
    $meatType = mysqli_real_escape_string($conn, $_POST["meatType"]);
    $Consumption_Per_Capita = mysqli_real_escape_string($conn, $_POST["Consumption_Per_Capita"]);  // Corrected column name
    $Protein = mysqli_real_escape_string($conn, $_POST["Protein"]);                    // Corrected column name
    $Fat = mysqli_real_escape_string($conn, $_POST["Fat"]);                            // Corrected column name
    $Calories = mysqli_real_escape_string($conn, $_POST["Calories"]);                  // Corrected column name
    $Regional_Preference_Index = mysqli_real_escape_string($conn, $_POST["Regional_Preference_Index"]);  // Corrected column name

    // Perform validation (e.g., check data types, ranges, etc.)
    // For example:
    if (empty($nutritionId) || empty($meatType) || empty($year)) {
        echo "Error: Nutrition ID, Meat Type, and Year are required.";
        exit; // Stop execution if validation fails
    }

    $sql = "INSERT INTO Nutrition_T (   --  TABLE NAME CORRECTED
                `Nutrition_ID`, `Year`, `Meat_Type`, `Consumption_Per_Capita`,  -- COLUMN NAMES CORRECTED
                `Protein`, `Fat`, `Calories`, 
                `Regional_Preference_Index`
            ) VALUES (
                '$nutritionId', '$year', '$meatType', '$Consumption_Per_Capita', 
                '$Protein', '$Fat', '$Calories', '$Regional_Preference_Index'
  
            )";

    if ($conn->query($sql) === TRUE) {
        echo '<div class="alert alert-success" role="alert">New record created successfully!</div>';
        header("refresh:2; url=f3_view.php"); // Redirect to view page  // Updated link
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>