// Wait for the page to fully load
window.onload = function () {
    // Get references to the input fields
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');

    // Set default values
    usernameInput.value = localStorage.getItem("username");
    passwordInput.value = localStorage.getItem("password");

    GetBirthAndWeight(localStorage.getItem("username"));

};


async function GetBirthAndWeight(username){
    try {
        // Ustvari URL z uporabniškim imenom kot query parameter
        const url = `userji.php?userVzdevek=${encodeURIComponent(username)}`;
        
        const response = await fetch(url, {
            method: 'GET'
        });  

        //alert('Respond status: ' + response.status);

        if (!response.ok) {
            throw new Error('Napaka pri pridobivanju podatkov. Status: ' + response.status);
        }

        //console.log(response);
        const data = await response.json(); // Predpostavimo, da server vrne JSON
        //console.log(data);

        const birthdayInput = document.getElementById('birthday');
        const weightInput = document.getElementById('weight');

        if (birthdayInput && weightInput) {
            birthdayInput.value = data.birthday; // Nastavi datum rojstva
            weightInput.value = data.weight;     // Nastavi težo
        } else {
            console.error('Input polja za birthday ali weight niso najdena.');
        }


    } catch (error) {
        console.error('Error:', error);
        alert('Failed to connect to the server.');
    }
}





async function handleFormProfile(event) {
    event.preventDefault(); // Prepreči privzeto vedenje obrazca

    username = localStorage.getItem("username");
    const password = document.getElementById('password').value;
    const birthday = document.getElementById('birthday').value;
    const weight = document.getElementById('weight').value;
    

    try {
        const response = await fetch('userji.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ username: username, password: password, birthday: birthday, weight: weight}),
        });
            
        alert('Respond status: ' + response.status);
        

        
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to connect to the server.');
    }

}






async function deleteProfile() {

    username = localStorage.getItem("username");

    try {
        const response = await fetch('userji.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ username: username}),
        });
            
        alert('Respond status: ' + response.status);

        if (response.ok) {
            // Redirect to a new page after successful profile deletion
            window.location.href = 'index.php';  // Replace with your desired URL
        } 
        

        
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to connect to the server.');
    }

}