
window.onload = function () {
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');

    usernameInput.value = localStorage.getItem("username");
    passwordInput.value = localStorage.getItem("password");

    GetBirthAndWeight(localStorage.getItem("username"));

};


async function GetBirthAndWeight(username){
    try {
        const url = `userji.php?userVzdevek=${encodeURIComponent(username)}`;
        
        const response = await fetch(url, {
            method: 'GET'
        });  


        if (!response.ok) {
            throw new Error('Napaka pri pridobivanju podatkov. Status: ' + response.status);
        }

        const data = await response.json(); 

        const birthdayInput = document.getElementById('birthday');
        const weightInput = document.getElementById('weight');

        if (birthdayInput && weightInput) {
            birthdayInput.value = data.birthday; 
            weightInput.value = data.weight;    
        } else {
            console.error('Input polja za birthday ali weight niso najdena.');
        }


    } catch (error) {
        console.error('Error:', error);
        alert('Failed to connect to the server.');
    }
}





async function handleFormProfile(event) {
    event.preventDefault(); 

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
            
        alert('Profile successfuly updated.');
        
        
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
            
        alert('Profile succesfully deleted.');

        if (response.ok) {
            window.location.href = 'index.php';  
        } 
        

        
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to connect to the server.');
    }

}