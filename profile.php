<?php

echo"<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Profile Page</title>
    <link rel='stylesheet' href='styles.css'> <!-- Link to the external CSS file -->
</head>
<body>
    <a href='home.php' class='home-button'>Home</a>
    <div> 
      <h1>Profile</h1>
        <form onsubmit='handleFormProfile(event)'>
            <div class='form-group'>
                <label for='username'>Username:</label>
                <input type='text' id='username' name='username' placeholder='Enter your username' value='DefaultUsername'>
            </div>

            <div class='form-group'>
                <label for='password'>Password:</label>
                <input type='password' id='password' name='password' placeholder='Enter your password'>
            </div>

            <div class='form-group'>
                <label for='birthday'>Birthday:</label>
                <input type='date' id='birthday' name='birthday'>
            </div>

            <div class='form-group'>
                <label for='weight'>Weight (kg):</label>
                <input type='number' id='weight' name='weight' min='0' max='300' step='0.1' placeholder='Enter your weight'>
            </div>

            <div class='form-group'>
                <button type='submit' class='save-button'>Save</button>
            </div>
        </form>
        <div class='form-group'>
                <button type='submit' class='save-button' onclick='deleteProfile()'>Delete Profile</button>
        </div>
        <a href='index.php' class='other-button'>Log Out</a>
    </div>
    <script src='scriptProfile.js'></script>
</body>
</html>"

?>