<?php
// Include the database connection
include('db_connect.php');

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to fetch all records from the livestock table
$query = "SELECT * FROM livestock_t";
$result = mysqli_query($conn, $query);

// Check if any rows were returned
if (mysqli_num_rows($result) > 0) {
    // Table to display records
    echo '<table class="table table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Year</th>';
    echo '<th>Animal Type</th>';
    echo '<th>Animal Count</th>';
    echo '<th>Region</th>';
    echo '<th>Production Cost</th>';
    echo '<th>Actions</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    
    // Loop through all records and display in the table
    while ($row = mysqli_fetch_assoc($result)) {
        // Ensure each field exists and handle null or empty values
        $livestock_id = isset($row['Livestock_ID']) ? htmlspecialchars($row['Livestock_ID']) : 'N/A';
        $year = isset($row['Year']) ? htmlspecialchars($row['Year']) : 'N/A';
        $animal_type = isset($row['Animal_Type']) ? htmlspecialchars($row['Animal_Type']) : 'N/A';
        $animal_count = isset($row['Animal_Count']) ? htmlspecialchars($row['Animal_Count']) : 'N/A';
        $region = isset($row['Region']) ? htmlspecialchars($row['Region']) : 'N/A';
        $production_cost = isset($row['Production_Cost_Per_Animal']) ? htmlspecialchars($row['Production_Cost_Per_Animal']) : 'N/A';

        echo '<tr>';
        echo '<td>' . $livestock_id . '</td>';
        echo '<td>' . $year . '</td>';
        echo '<td>' . $animal_type . '</td>';
        echo '<td>' . $animal_count . '</td>';
        echo '<td>' . $region . '</td>';
        echo '<td>' . $production_cost . '</td>';

        // Add actions if the record exists
        echo '<td>';
        echo '<a href="edit_livestock.php?id=' . urlencode($livestock_id) . '" class="btn btn-sm btn-warning">Edit</a> ';
        echo '<a href="delete_livestock.php?id=' . urlencode($livestock_id) . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Delete this record?\')">Delete</a>';
        echo '</td>';

        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
} else {
    echo "<p>No records found.</p>";
}

// Close the database connection
mysqli_close($conn);
?>
