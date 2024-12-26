async function handleForm(event) {
    event.preventDefault(); // Prepreči privzeto vedenje obrazca
    
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    localStorage.setItem("username", username);
	localStorage.setItem("password", password);
    
    if (!username) {
        alert('Please enter a username.');
        return;
    }

    try {
        const response = await fetch('userji.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ username: username, password: password }),
        });

        if (response.status === 201) {
            alert('User registered successfully!');
            window.location.href = 'home.php';
        } else if (response.status === 200) {
            alert('User already exists!');
            window.location.href = 'home.php';
        } else {
            alert('An error occurred. Please try again later.' + response.status);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to connect to the server.');
    }
}
