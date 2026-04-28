const ctx = document.getElementById('chart');

// Labels
const labels = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];

// Sample data
const fullData = [12,19,8,15,22,10,17, 14];

// Get today index (Mon = 0)
const today = new Date().getDay();
const adjustedToday = today === 0 ? 6 : today - 1;

// Build 7-day loop ending TODAY
let visibleLabels = [];
let visibleData = [];
let backgroundColors = [];

for (let i = 6; i >= 0; i--) {
    let index = (adjustedToday - i + 7) % 7;

    visibleLabels.push(labels[index]);
    visibleData.push(fullData[index]);

    // Highlight today (last bar)
    backgroundColors.push(
        i === 0
        ? 'rgba(255, 99, 132, 0.9)'  // 🔴 today
        : 'rgba(25, 135, 84, 0.7)'   // 🟢 others
    );
}

new Chart(document.getElementById('chart'), {
    type: 'bar',
    data: {
        labels: window.dashboardData.barLabels,
        datasets: [{
            label: 'Transactions per Day',
            data: window.dashboardData.barData,
            backgroundColor: 'rgba(25, 135, 84, 0.7)'
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

const pie_chart = document.getElementById('pie_chart');

new Chart(document.getElementById('pie_chart'), {
    type: 'pie',
    data: {
        labels: window.dashboardData.pieLabels,
        datasets: [{
            data: window.dashboardData.pieData,
            backgroundColor: [
                '#198754',
                '#0d6efd',
                '#ffc107',
                '#dc3545',
                '#6f42c1',
                '#20c997',
                '#6610f2',
                '#fd7e14'
            ]
        }]
    },
    options: {
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

const map = L.map('map').setView([11.8166, 122.0942], 10); // Antique, PH

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

// Sample municipalities with transaction data
const data = [
    { name: "San Jose", coords: [10.752, 121.941], transactions: 50 },
    { name: "Sibalom", coords: [10.790, 122.010], transactions: 30 },
    { name: "Hamtic", coords: [10.700, 121.980], transactions: 20 }
];

// Add markers
data.forEach(item => {
    L.circleMarker(item.coords, {
        radius: item.transactions / 5, // size based on data
        color: 'green',
        fillOpacity: 0.5
    })
    .addTo(map)
    .bindPopup(`<b>${item.name}</b><br>Transactions: ${item.transactions}`);
});