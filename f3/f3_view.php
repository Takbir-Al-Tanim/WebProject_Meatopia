<?php
include __DIR__ . '/db_connect.php';

$sql = "SELECT * FROM Nutrition_T";
$result = $conn->query($sql);

// Prepare data for charts
$years = [];
$meatTypes = [];
$consumptionData = [];
$proteinData = [];
$fatData = [];
$caloriesData = [];

$sql_chart = "SELECT `Year`, `Meat_Type`, `Consumption_Per_Capita`, `Protein`, `Fat`, `Calories`, `Regional_Preference_Index` FROM Nutrition_T ORDER BY `Year`, `Meat_Type`";
$result_chart = $conn->query($sql_chart);

if ($result_chart->num_rows > 0) {
    while ($row = $result_chart->fetch_assoc()) {
        $year = $row["Year"];
        $meatType = $row["Meat_Type"];
        $consumption = $row["Consumption_Per_Capita"];
        $protein = $row["Protein"];
        $fat = $row["Fat"];
        $calories = $row["Calories"];
        $regionalIndex = $row["Regional_Preference_Index"];

        if (!in_array($year, $years)) {
            $years[] = $year;
        }
        if (!in_array($meatType, $meatTypes)) {
            $meatTypes[] = $meatType;
            $consumptionData[$meatType] = [];
            $proteinData[$meatType] = [];
            $fatData[$meatType] = [];
            $caloriesData[$meatType] = [];
        }

        $consumptionData[$meatType][$year] = $consumption;
        $proteinData[$meatType][$year] = $protein;
        $fatData[$meatType][$year] = $fat;
        $caloriesData[$meatType][$year] = $calories;
    }
}

// --- Additional Queries for Dashboard ---
// *** IMPORTANT:  Replace these with your actual table and column names ***

// Total Consumption
$sql_total_consumption = "SELECT SUM(Consumption_Per_Capita) AS total_consumption FROM Nutrition_T";
$result_total_consumption = $conn->query($sql_total_consumption);
$row_total_consumption = $result_total_consumption->fetch_assoc();
$totalConsumption = $row_total_consumption['total_consumption'] ?? 0;

// Average Calories
$sql_avg_calories = "SELECT AVG(Calories) AS avg_calories FROM Nutrition_T";
$result_avg_calories = $conn->query($sql_avg_calories);
$row_avg_calories = $result_avg_calories->fetch_assoc();
$avgCalories = $row_avg_calories['avg_calories'] ?? 0;

// Example:  Meat Type with Highest Consumption (Illustrative - Adapt as needed)
$sql_highest_consumption = "SELECT Meat_Type, SUM(Consumption_Per_Capita) as total FROM Nutrition_T GROUP BY Meat_Type ORDER BY total DESC LIMIT 3";
$result_highest_consumption = $conn->query($sql_highest_consumption);
$topMeatTypes = [];
if ($result_highest_consumption->num_rows > 0) {
    while ($row = $result_highest_consumption->fetch_assoc()) {
        $topMeatTypes[] = $row;
    }
}

// Example:  Year with Highest Calories (Illustrative - Adapt as needed)
$sql_highest_calories_year = "SELECT `Year`, AVG(Calories) as avg_calories FROM Nutrition_T GROUP BY `Year` ORDER BY avg_calories DESC LIMIT 3";
$result_highest_calories_year = $conn->query($sql_highest_calories_year);
$topCalorieYears = [];
if ($result_highest_calories_year->num_rows > 0) {
    while ($row = $result_highest_calories_year->fetch_assoc()) {
        $topCalorieYears[] = $row;
    }
}

// Price Trend Data (Illustrative - Replace with your actual price data query)
$sql_price_trend = "SELECT `Year`, AVG(Calories) as avg_calories FROM Nutrition_T GROUP BY `Year` ORDER BY `Year`";
$result_price_trend = $conn->query($sql_price_trend);
$priceDates = [];
$priceValues = [];
if ($result_price_trend->num_rows > 0) {
    while ($row = $result_price_trend->fetch_assoc()) {
        $priceDates[] = $row['Year'];  // Assuming 'Year' can represent your time dimension
        $priceValues[] = $row['avg_calories']; // Using Calories as a placeholder for price.  REPLACE THIS!
    }
}

// Supply and Demand Data (Illustrative - Replace with your actual supply/demand query)
$sql_supply_demand = "SELECT `Year`, AVG(Protein) as avg_protein, AVG(Fat) as avg_fat FROM Nutrition_T GROUP BY `Year` ORDER BY `Year`"; // Example: Using Protein and Fat as placeholders
$result_supply_demand = $conn->query($sql_supply_demand);
$supplyDemandLabels = [];
$supplyData = [];
$demandData = [];
if ($result_supply_demand->num_rows > 0) {
    while ($row = $result_supply_demand->fetch_assoc()) {
        $supplyDemandLabels[] = $row['Year'];
        $supplyData[] = $row['avg_protein'];  // Placeholder - Replace with your supply data
        $demandData[] = $row['avg_fat'];    // Placeholder - Replace with your demand data
    }
}

// --- End of Additional Queries ---


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Consumer Demand Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  <style>
        .chart-container {
            margin-bottom: 20px;
        }

        .chart-container canvas {
            max-height: 300px;
        }

        .dashboard-card {
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 15px;
            text-align: center;
        }

        .dashboard-card h4 {
            margin-top: 0;
            margin-bottom: 10px;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Consumer Demand Data</h2>
            <a href="f3_form1.html" class="btn btn-success">Add New Entry</a>
        </div>

        <div class="table-responsive">
            <table id="myTable" class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nutrition ID</th>
                        <th>Year</th>
                        <th>Meat Type</th>
                        <th>Consumption/Capita (kg)</th>
                        <th>Protein (g)</th>
                        <th>Fat (g)</th>
                        <th>Calories (kcal)</th>
                        <th>Regional Preference Index</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["Nutrition_ID"] . "</td>";
                            echo "<td>" . $row["Year"] . "</td>";
                            echo "<td>" . $row["Meat_Type"] . "</td>";
                            echo "<td>" . $row["Consumption_Per_Capita"] . "</td>";
                            echo "<td>" . $row["Protein"] . "</td>";
                            echo "<td>" . $row["Fat"] . "</td>";
                            echo "<td>" . $row["Calories"] . "</td>";
                            echo "<td>" . $row["Regional_Preference_Index"] . "</td>";
                            echo "<td>
                                    <a href='f3_update.php?id=" . $row["Nutrition_ID"] . "' class='btn btn-sm btn-warning me-1'>Edit</a>  <a href='f3_delete.php?id=" . $row["Nutrition_ID"] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this record?\")'>Delete</a>  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No data available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="mt-5">
            <h3 class="mb-4"></h3>

            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="dashboard-card bg-primary text-white">
                        <h4>Total Consumption</h4>
                        <p class="mb-0"><?php echo number_format($totalConsumption, 2); ?> kg</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-card bg-success text-white">
                        <h4>Avg. Calories</h4>
                        <p class="mb-0"><?php echo number_format($avgCalories, 2); ?> kcal</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-card bg-warning text-dark">
                        <h4>Highest Consumed Meat</h4>
                        <?php if (!empty($topMeatTypes)) : ?>
                            <ol class="mb-0">
                                <?php foreach ($topMeatTypes as $meat) : ?>
                                    <li><?php echo htmlspecialchars($meat['Meat_Type']); ?> (<?php echo number_format($meat['total'], 2); ?> kg)</li>
                                <?php endforeach; ?>
                            </ol>
                        <?php else : ?>
                            <p class="mb-0">No data</p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-card bg-danger text-white">
                        <h4>Highest Calorie Years</h4>
                        <?php if (!empty($topCalorieYears)) : ?>
                            <ol class="mb-0">
                                <?php foreach ($topCalorieYears as $year) : ?>
                                    <li><?php echo $year['Year']; ?> (<?php echo number_format($year['avg_calories'], 2); ?> kcal)</li>
                                <?php endforeach; ?>
                            </ol>
                        <?php else : ?>
                            <p class="mb-0">No data</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="chart-container">
                        <canvas id="priceTrendChart"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="chart-container">
                        <canvas id="supplyDemandChart"></canvas>
                    </div>
                </div>
                <?php foreach ($meatTypes as $meatType) : ?>
                    <div class="col-md-6">
                        <div class="chart-container">
                            <canvas id="chart_<?php echo str_replace(' ', '', $meatType); ?>"></canvas>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php foreach ($meatTypes as $meatType) : ?>
                var ctx = document.getElementById('chart_<?php echo str_replace(' ', '', $meatType); ?>').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'radar',
                    data: {
                        labels: ['Consumption', 'Protein', 'Fat', 'Calories'],
                        datasets: [{
                            label: '<?php echo $meatType; ?>',
                            data: [
                                <?php
                                    $lastYear = end($years);
                                    echo isset($consumptionData[$meatType][$lastYear]) ? $consumptionData[$meatType][$lastYear] : 0;
                                    ?>,
                                <?php
                                    echo isset($proteinData[$meatType][$lastYear]) ? $proteinData[$meatType][$lastYear] : 0;
                                    ?>,
                                <?php
                                    echo isset($fatData[$meatType][$lastYear]) ? $fatData[$meatType][$lastYear] : 0;
                                    ?>,
                                <?php
                                    echo isset($caloriesData[$meatType][$lastYear]) ? $caloriesData[$meatType][$lastYear] : 0;
                                    ?>
                            ],
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgb(255, 99, 132)',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            r: {
                                beginAtZero: true,
                                pointLabels: {
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Nutritional Profile: <?php echo $meatType; ?>'
                            }
                        }
                    }
                });
            <?php endforeach; ?>

            // Price Trend Chart
            var ctxPrice = document.getElementById('priceTrendChart').getContext('2d');
            var priceTrendChart = new Chart(ctxPrice, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($priceDates); ?>,
                    datasets: [{
                        label: 'Average Calories',  // Change to your actual label
                        data: <?php echo json_encode($priceValues); ?>,
                        borderColor: 'blue',
                        borderWidth: 2,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: false,
                            title: {
                                display: true,
                                text: 'Average Calories'  // Change to your actual y-axis label
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Year'   // Change to your actual x-axis label
                            }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Average Calories Over Time' // Change to your actual chart title
                        }
                    }
                }
            });

            // Supply and Demand Chart
            var ctxSupplyDemand = document.getElementById('supplyDemandChart').getContext('2d');
            var supplyDemandChart = new Chart(ctxSupplyDemand, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($supplyDemandLabels); ?>,
                    datasets: [{
                        label: 'Avg. Protein',  // Change to your actual label
                        data: <?php echo json_encode($supplyData); ?>,
                        backgroundColor: 'green',
                        borderColor: 'green',
                        borderWidth: 1
                    }, {
                        label: 'Avg. Fat',   // Change to your actual label
                        data: <?php echo json_encode($demandData); ?>,
                        backgroundColor: 'red',
                        borderColor: 'red',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Value'  // Change to your actual y-axis label
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Year'   // Change to your actual x-axis label
                            }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Average Protein and Fat Over Time'  // Change to your actual chart title
                        }
                    }
                }
            });

        });
    </script>
</body>

</html>
<?php $conn->close(); ?>