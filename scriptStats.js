const inputField = document.getElementById('exercise');
const submitButton = document.getElementById('submitButton'); 

submitButton.addEventListener('click', () => {
    const enteredValue = inputField.value;
    fetchAndRenderChart(enteredValue);
  
});


let chartInstance = null; 


async function fetchAndRenderChart(exercise) {
    try {
      const username = localStorage.getItem("username");
      const apiUrl = `graphStats.php?username=${username}&exercise=${exercise}`; 
  
      const response = await fetch(apiUrl);
  
      if (!response.ok) {
        throw new Error(`API Error: ${response.status}`);
      }
  
      const data = await response.json();
  
      const dates = data.map(item => item.date);
      const weights = data.map(item => item.weight);
  
      const ctx = document.getElementById('weightChart').getContext('2d');

        if (chartInstance) {
            chartInstance.destroy();
        } 

        chartInstance = new Chart(ctx, {
        type: 'line', 
        data: {
          labels: dates, 
          datasets: [{
            label: 'Weight Progress',
            data: weights, 
            borderColor: '#800020',
            backgroundColor: '#800020',
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
  
  