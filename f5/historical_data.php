<?php
include __DIR__ . '/db_connect.php';

// Fetch historical price data
$sql = "SELECT Meat_Type, YEAR(Order_Date) AS year, AVG(Unit_Price) AS avg_price FROM Order_T GROUP BY Meat_Type, year ORDER BY Meat_Type, year";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[$row['Meat_Type']][$row['year']] = $row['avg_price'];
}

echo json_encode($data);
?>
