<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Overview | Meatopia Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    .chart-container {
      height: 300px; /* Fixed height to prevent expanding */
    }
    canvas {
      width: 100% !important;
      height: 100% !important;
    }
  </style>
</head>
<body>

<div class="container mt-4">
  <h2 class="mb-4">Meat Product Analysis Dashboard</h2>

  <!-- Key Stats -->
  <div class="row">
    <div class="col-md-3">
      <div class="card text-white bg-primary p-3">
        <h6>Total Inventory</h6>
        <h3>12,500 kg</h3>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-success p-3">
        <h6>Market Price (Avg)</h6>
        <h3>৳520/kg</h3>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-warning p-3">
        <h6>Supply vs Demand</h6>
        <h3>80% / 90%</h3>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-danger p-3">
        <h6>Cold Storage Usage</h6>
        <h3>65%</h3>
      </div>
    </div>
  </div>

  <!-- Charts -->
  <div class="row mt-4">
    <div class="col-md-6">
      <div class="card p-3 chart-container">
        <h6>Price Trends (Historical)</h6>
        <canvas id="historicalChart"></canvas>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card p-3 chart-container">
        <h6>Current Prices (৳/kg)</h6>
        <canvas id="currentChart"></canvas>
      </div>
    </div>
  </div>

  <!-- Buyer & Seller Directory -->
  <div class="row mt-4 mb-5">
    <div class="col-md-6">
      <div class="card p-3">
        <h6>Top Buyers</h6>
        <ul>
          <li>🔹 Smith's Meat Supply</li>
          <li>🔹 Green Farms Market</li>
          <li>🔹 Metro Superstore</li>
        </ul>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card p-3">
        <h6>Top Sellers</h6>
        <ul>
          <li>🔹 Johnson's Livestock</li>
          <li>🔹 Fresh Cuts Butchery</li>
          <li>🔹 Organic Meat Co.</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<script>
const meatColors = {
  Beef: '#E63946',
  Chicken: '#FFBE0B',
  Mutton: '#F8961E',
  Lamb: '#3A86FF'
};

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      position: 'top',
      labels: {
        font: { size: 13 },
        padding: 20,
        usePointStyle: true,
        pointStyle: 'circle'
      }
    },
    tooltip: {
      backgroundColor: 'rgba(0,0,0,0.8)',
      titleFont: { size: 14, weight: 'bold' },
      bodyFont: { size: 13 },
      padding: 12,
      cornerRadius: 8,
      displayColors: true,
      callbacks: {
        label: ctx => ` ${ctx.dataset.label}: ৳${ctx.raw.toFixed(2)}`
      }
    }
  },
  scales: {
    y: {
      beginAtZero: false,
      grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
      ticks: { callback: value => '৳' + value.toFixed(2) },
      title: { display: true, text: 'Price per kg (৳)', font: { size: 13, weight: 'bold' } }
    },
    x: {
      grid: { display: false },
      title: { display: true, text: 'Year', font: { size: 13, weight: 'bold' } }
    }
  }
};

// Historical Trends (Line Chart)
fetch('historical_data.php')
  .then(response => response.json())
  .then(data => {
    const years = new Set();
    Object.values(data).forEach(meatData => {
      Object.keys(meatData).forEach(year => years.add(year));
    });
    const labels = Array.from(years).sort();
    const datasets = Object.entries(data).map(([meat, prices]) => {
      const color = meatColors[meat] || '#333';
      return {
        label: `${meat} (৳/kg)`,
        data: labels.map(year => prices[year] || null),
        borderColor: color,
        backgroundColor: color + '33',
        pointBackgroundColor: color,
        borderWidth: 3,
        tension: 0.2,
        fill: true
      };
    });
    new Chart(document.getElementById('historicalChart'), {
      type: 'line',
      data: { labels, datasets },
      options: chartOptions
    });
  })
  .catch(error => {
    console.error('Error loading historical data:', error);
  });

// Current Prices (Bar Chart)
fetch('current_data.php')
  .then(response => response.json())
  .then(data => {
    const labels = data.map(entry => entry.label);
    const values = data.map(entry => entry.value);
    const colors = labels.map(meat => meatColors[meat] || '#333');
    new Chart(document.getElementById('currentChart'), {
      type: 'bar',
      data: {
        labels,
        datasets: [{
          label: 'Current Price (৳/kg)',
          data: values,
          backgroundColor: colors.map(c => c + 'CC'),
          borderColor: colors,
          borderWidth: 1,
          borderRadius: 6
        }]
      },
      options: { ...chartOptions, plugins: { ...chartOptions.plugins, legend: { display: false } } }
    });
  })
  .catch(error => {
    console.error('Error loading current price data:', error);
  });
</script>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
