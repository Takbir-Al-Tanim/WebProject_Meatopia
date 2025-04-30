<?php
include __DIR__ . '/db_connect.php';

// Fetch current price data
$sql = "SELECT Meat_Type, MAX(Order_Date) AS latest_date, Unit_Price FROM Order_T GROUP BY Meat_Type";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        'label' => $row['Meat_Type'],
        'value' => $row['Unit_Price']
    ];
}

echo json_encode($data);
?>
