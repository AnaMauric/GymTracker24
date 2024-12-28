// Wait for the page to fully load
window.onload = function () {
    // Get references to the input fields
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');

    // Set default values
    usernameInput.value = localStorage.getItem("username");
    passwordInput.value = localStorage.getItem("password");
};




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
            
        alert('Respond status - 69: ' + response.status);
        

        
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