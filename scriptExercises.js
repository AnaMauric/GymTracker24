function getvariables(){
    username = localStorage.getItem("username");
    password = localStorage.getItem("password");
}; 


document.addEventListener("DOMContentLoaded", () => {
    fetchData();
}); 


async function handleForm(event) {
    event.preventDefault(); 
    
    const exerciseName = document.getElementById('exercise-name').value;
    const weight = document.getElementById('weight').value;
    const sets = document.getElementById('sets').value;
    const reps = document.getElementById('reps').value;
    username = localStorage.getItem("username");

    try {
        const response = await fetch('exercises.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ username: username, exercise_name: exerciseName, weight: weight, sets:sets, reps: reps}),
        });
        
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to connect to the server.');
    }

    fetchData();
}



async function handleFormDelete(event) {
    event.preventDefault(); 
    
    const exerciseName = document.getElementById('exercise-delete').value;
    const dat = document.getElementById('dat').value;
    username = localStorage.getItem("username");    

    try {
        const response = await fetch('exercises.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ username: username, exercise_name: exerciseName, date:dat}),
        });
            

    } catch (error) {
        console.error('Error:', error);
        alert('Failed to connect to the server.');
    }

    fetchData();
}



async function fetchData() {
    const username = localStorage.getItem("username"); 

    try {
        const url = `exercises.php?username=${encodeURIComponent(username)}`;
        
        const response = await fetch(url, {
            method: 'GET'
        }); 

        if (!response.ok) {
            throw new Error('Error while getting data. Status: ' + response.status);
        }

        const data = await response.json(); 

        const tableBody = document.querySelector("#data-table tbody");
        tableBody.innerHTML = ''; 
        data.forEach(item => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${item.date}</td>
                <td>${item.exercise_name}</td>
                <td>${item.weight}</td>
                <td>${item.sets}</td>
                <td>${item.reps}</td>
            `;
            tableBody.appendChild(row);
        });


    } catch (error) {
        console.error('Error:', error);
        alert('Failed to connect to the server.');
    }
}
