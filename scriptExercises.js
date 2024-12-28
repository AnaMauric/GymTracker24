function getvariables(){
    username = localStorage.getItem("username");
    password = localStorage.getItem("password");
}; 


document.addEventListener("DOMContentLoaded", () => {
    fetchData();
});


async function handleForm(event) {
    event.preventDefault(); // Prepreči privzeto vedenje obrazca
    
    const exerciseName = document.getElementById('exercise-name').value;
    const weight = document.getElementById('weight').value;
    const sets = document.getElementById('sets').value;
    const reps = document.getElementById('reps').value;
    username = localStorage.getItem("username");
    //password = localStorage.getItem("password");

    

    try {
        const response = await fetch('exercises.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ username: username, exercise_name: exerciseName, weight: weight, sets:sets, reps: reps}),
        });
            
        //alert('Respond status: ' + response.status);
        

        
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to connect to the server.');
    }

    fetchData();
}



async function handleFormDelete(event) {
    event.preventDefault(); // Prepreči privzeto vedenje obrazca
    
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
            
        alert('Respond status: ' + response.status);
        

        
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to connect to the server.');
    }

    fetchData();
}



async function fetchData() {
    const username = localStorage.getItem("username"); // Pridobi uporabniško ime

    try {
        // Ustvari URL z uporabniškim imenom kot query parameter
        const url = `exercises.php?username=${encodeURIComponent(username)}`;
        
        const response = await fetch(url, {
            method: 'GET'
        });

        //alert('Respond status: ' + response.status);

        if (!response.ok) {
            throw new Error('Napaka pri pridobivanju podatkov. Status: ' + response.status);
        }

        const data = await response.json(); // Predpostavimo, da server vrne JSON

        // Napolni tabelo s podatki
        const tableBody = document.querySelector("#data-table tbody");
        tableBody.innerHTML = ''; // Počisti obstoječe vrstice
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
