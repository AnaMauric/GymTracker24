fetch('/path-to-your-endpoint')
    .then(response => response.json())
    .then(data => {
        // Iz podatkov SQL pridobi datume in težo
        const dates = data.map(entry => entry.date);
        const weights = data.map(entry => entry.weight);

        // Ustvari graf z datumi na osi Y in težo na osi X
        createChart(dates, weights);
    });

function createChart(dates, weights) {
    const ctx = document.getElementById('statisticsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line', // Ali drug tip grafa\n",
        data: {
            labels: weights, // X-axis (weights)\n",
            datasets: [{
                label: 'Weight Over Time',
                data: dates.map((date, i) => ({ x: weights[i], y: date })), // x=weight, y=date
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    type: 'linear', // Linear scale for weights
                    title: {
                        display: true,
                        text: 'Weight (kg)'
                    }
                },
                y: {
                    type: 'time', // Time scale for dates
                    time: {
                        unit: 'day'
                    },
                    title: {
                        display: true,
                        text: 'Date'
                    }
                }
            }
        }
    });
}



//to moraš povezat z graphStats.js