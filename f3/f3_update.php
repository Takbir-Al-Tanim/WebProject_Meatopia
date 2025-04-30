<?php 
include __DIR__ . '/db_connect.php'; 

if (isset($_POST['update'])) {
    // Sanitize and validate updated data (VERY IMPORTANT!)
    $nutritionId = mysqli_real_escape_string($conn, $_POST["nutritionId"]);
    $year = mysqli_real_escape_string($conn, $_POST["year"]);
    $meatType = mysqli_real_escape_string($conn, $_POST["meatType"]);
    $consumption = mysqli_real_escape_string($conn, $_POST["Consumption_Per_Capita"]);  // Corrected column name
    $protein = mysqli_real_escape_string($conn, $_POST["Protein"]);                    // Corrected column name
    $fat = mysqli_real_escape_string($conn, $_POST["Fat"]);                            // Corrected column name
    $calories = mysqli_real_escape_string($conn, $_POST["Calories"]);                  // Corrected column name
    $regionalIndex = mysqli_real_escape_string($conn, $_POST["Regional_Preference_Index"]);  // Corrected column name

    $sql = "UPDATE Nutrition_T SET   -- TABLE NAME CORRECTED
                `Year` = '$year',
                `Meat_Type` = '$meatType',
                `Consumption_Per_Capita` = '$consumption',
                `Protein` = '$protein',
                `Fat` = '$fat',
                `Calories` = '$calories',
                `Regional_Preference_Index` = '$regionalIndex'
            WHERE `Nutrition_ID` = '$nutritionId'";

    if ($conn->query($sql) === TRUE) {
        echo '<div class="alert alert-success" role="alert">Record updated successfully!</div>';
        header("refresh:2; url=f3_view.php");  // Updated link
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "SELECT * FROM Nutrition_T WHERE `Nutrition_ID` = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nutritionId = $row["Nutrition_ID"];
        $year = $row["Year"];
        $meatType = $row["Meat_Type"];
        $consumption = $row["Consumption_Per_Capita"];  // Corrected column name
        $protein = $row["Protein"];                    // Corrected column name
        $fat = $row["Fat"];                            // Corrected column name
        $calories = $row["Calories"];                  // Corrected column name
        $regionalIndex = $row["Regional_Preference_Index"];  // Corrected column name

    } else {
        echo "Record not found!";
        exit;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Consumer Demand Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h2 class="text-center mb-4">Edit Consumer Demand Data</h2>

        <form action="" method="POST" class="card p-4 shadow-sm">
            <div class="mb-3">
                <label for="nutritionId" class="form-label">Nutrition ID</label>
                <input type="text" class="form-control" id="nutritionId" name="nutritionId" value="<?php echo $nutritionId; ?>" required readonly>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="year" class="form-label">Year</label>
                    <input type="number" class="form-control" id="year" name="year" value="<?php echo $year; ?>" required>
                </div>
                <div class="col">
                    <label for="meatType" class="form-label">Meat Type</label>
                    <input type="text" class="form-control" id="meatType" name="meatType" value="<?php echo $meatType; ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="Consumption_Per_Capita" class="form-label">Consumption/Capita (kg)</label>
                    <input type="number" step="0.01" class="form-control" id="Consumption_Per_Capita" name="Consumption_Per_Capita" value="<?php echo $consumption; ?>" required>
                </div>
                <div class="col">
                    <label for="Regional_Preference_Index" class="form-label">Regional Preference Index</label>
                    <input type="number" step="0.01" class="form-control" id="Regional_Preference_Index" name="Regional_Preference_Index" value="<?php echo $regionalIndex; ?>" required>
                </div>
                </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="Protein" class="form-label">Protein (g)</label>
                    <input type="number" step="0.01" class="form-control" id="Protein" name="Protein" value="<?php echo $protein; ?>" required>
                </div>
                <div class="col">
                    <label for="Fat" class="form-label">Fat (g)</label>
                    <input type="number" step="0.01" class="form-control" id="Fat" name="Fat" value="<?php echo $fat; ?>" required>
                </div>
                <div class="col">
                    <label for="Calories" class="form-label">Calories (kcal)</label>
                    <input type="number" step="0.01" class="form-control" id="Calories" name="Calories" value="<?php echo $calories; ?>" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3" name="update">Update Data</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>