const inputField = document.getElementById('exercise');
const submitButton = document.getElementById('submitButton'); 
const getWeightButton = document.getElementById('getWeightButton'); 

submitButton.addEventListener('click', () => {
    const enteredValue = inputField.value;
    fetchAndRenderChart(enteredValue);
  
});

getWeightButton.addEventListener('click', () => {
  fetchAndRenderChart2();

});


let chartInstance = null; 
let chartInstance2 = null;


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


  async function fetchAndRenderChart2() {
    try {
      const username = localStorage.getItem("username");
      const apiUrl = `weight.php?username=${username}`; 
  
      const response = await fetch(apiUrl);
  
      if (!response.ok) {
        throw new Error(`API Error: ${response.status}`);
      }
  
      const data = await response.json();
  
      const dates = data.map(item => item.date);
      const weights = data.map(item => item.weight);
  
      const ctx = document.getElementById('weightChart2').getContext('2d');

        if (chartInstance2) {
            chartInstance2.destroy();
        } 

        chartInstance2 = new Chart(ctx, {
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
  
  