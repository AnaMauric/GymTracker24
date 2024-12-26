function getvariables(){
    username = localStorage.getItem("username");
    password = localStorage.getItem("password");
};


async function handleForm(event) {
    event.preventDefault(); // Prepreči privzeto vedenje obrazca
    
    const exerciseName = document.getElementById('exercise-name').value;
    const weight = document.getElementById('weight').value;
    const sets = document.getElementById('sets').value;
    const reps = document.getElementById('reps').value;
    username = localStorage.getItem("username");
    password = localStorage.getItem("password");

    

    try {
        const response = await fetch('exercises.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ username: username, exercise_name: exerciseName, weight: weight, sets:sets, reps: reps}),
        });
            
        alert('Respond status: ' + response.status);
        

        
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to connect to the server.');
    }
}