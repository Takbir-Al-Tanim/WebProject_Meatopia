window.addEventListener("DOMContentLoaded", () => {
    const ctx1 = document.getElementById('priceChart')?.getContext('2d');
    if (ctx1) {
      new Chart(ctx1, {
        type: 'line',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
          datasets: [{
            label: 'Price per kg ($)',
            data: [4.5, 4.7, 4.9, 5.1, 5.3, 5.2],
            borderColor: 'blue',
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false
        }
      });
    }
  
    const ctx2 = document.getElementById('supplyChart')?.getContext('2d');
    if (ctx2) {
      new Chart(ctx2, {
        type: 'bar',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
          datasets: [
            {
              label: 'Supply',
              data: [80, 85, 83, 88, 90, 92],
              backgroundColor: 'green'
            },
            {
              label: 'Demand',
              data: [85, 87, 86, 89, 91, 95],
              backgroundColor: 'red'
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false
        }
      });
    }
  });
  