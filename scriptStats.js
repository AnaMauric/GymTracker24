// Izberemo vnosno polje in gumb
const inputField = document.getElementById('exercise');
const submitButton = document.getElementById('submitButton'); 

// Dogodek na klik gumba
submitButton.addEventListener('click', () => {
  // Dobimo vrednost iz vnosnega polja
    const enteredValue = inputField.value;
    fetchAndRenderChart(enteredValue);
  
});


let chartInstance = null; // Globalna spremenljivka za graf


// Function to fetch data and render the chart
async function fetchAndRenderChart(exercise) {
    try {
      // API URL with parameters
      const username = localStorage.getItem("username");
      //const exercise = "biceps curls";
      const apiUrl = `graphStats.php?username=${username}&exercise=${exercise}`; 
  
      // Fetch data from the API
      const response = await fetch(apiUrl);
  
      if (!response.ok) {
        throw new Error(`API Error: ${response.status}`);
      }
  
      const data = await response.json();
  
      // Extract dates and weights for the chart
      const dates = data.map(item => item.date);
      const weights = data.map(item => item.weight);
  
      // Render chart using Chart.js
      const ctx = document.getElementById('weightChart').getContext('2d');

      // Uniči obstoječi graf, če obstaja
        if (chartInstance) {
            chartInstance.destroy();
        } 


        chartInstance = new Chart(ctx, {
        type: 'line', // Line chart
        data: {
          labels: dates, // X-axis labels
          datasets: [{
            label: 'Weight Progress',
            data: weights, // Y-axis data
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderWidth: 2,
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              display: true,
              position: 'top',
            }
          },
          scales: {
            x: {
              title: {
                display: true,
                text: 'Date',
              }
            },
            y: {
              title: {
                display: true,
                text: 'Weight (kg)',
              }
            }
          }
        }
      });
    } catch (error) {
      console.error('Error fetching or rendering chart:', error);
    }
  }
  
  