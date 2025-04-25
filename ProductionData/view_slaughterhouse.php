<?php
// Include the database connection
include('db_connect.php');

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to fetch all records from the slaughterhouse table
$query = "SELECT * FROM slaughterhouse_t";
$result = mysqli_query($conn, $query);

// Check if any rows were returned
if (mysqli_num_rows($result) > 0) {
    // Table to display records
    echo '<table class="table table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Slaughterhouse Name</th>';
    echo '<th>Address</th>';
    echo '<th>Slaughter Capacity</th>';
    echo '<th>Slaughter Date</th>';
    echo '<th>Quantity Slaughtered</th>';
    echo '<th>Slaughtered Meat Type</th>';
    echo '<th>Actions</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    
    // Loop through all records and display in the table
    while ($row = mysqli_fetch_assoc($result)) {
        // Ensure each field exists and handle null or empty values
        $slaughterhouse_name = isset($row['Slaughterhouse_Name']) ? htmlspecialchars($row['Slaughterhouse_Name']) : 'N/A';
        $address = isset($row['Address']) ? htmlspecialchars($row['Address']) : 'N/A';
        $slaughter_capacity = isset($row['Slaughter_Capacity']) ? htmlspecialchars($row['Slaughter_Capacity']) : 'N/A';
        $slaughter_date = isset($row['Slaughter_Date']) ? htmlspecialchars($row['Slaughter_Date']) : 'N/A';
        $quantity_slaughtered = isset($row['Quantity_Slaughtered']) ? htmlspecialchars($row['Quantity_Slaughtered']) : 'N/A';
        $slaughtered_meat_type = isset($row['Slaughtered_Meat_Type']) ? htmlspecialchars($row['Slaughtered_Meat_Type']) : 'N/A';

        echo '<tr>';
        echo '<td>' . $slaughterhouse_name . '</td>';
        echo '<td>' . $address . '</td>';
        echo '<td>' . $slaughter_capacity . '</td>';
        echo '<td>' . $slaughter_date . '</td>';
        echo '<td>' . $quantity_slaughtered . '</td>';
        echo '<td>' . $slaughtered_meat_type . '</td>';

        // Actions column for Edit and Delete
        echo '<td>';
        echo '<a href="edit_slaughterhouse.php?name=' . urlencode($slaughterhouse_name) . '&address=' . urlencode($address) . '" class="btn btn-sm btn-warning">Edit</a> ';
        echo '<a href="delete_slaughterhouse.php?name=' . urlencode($slaughterhouse_name) . '&address=' . urlencode($address) . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Delete this record?\')">Delete</a>';
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
