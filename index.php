<?php
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>GymTracker 24</title>
        <link rel='stylesheet' href='styles.css'>
    </head>
    <body>
        <div class='container'>
            <h1>GymTracker 24</h1>
            <form onsubmit='handleForm(event)'>
                <div class='form-group'>
                    <label for='username'>Username</label>
                    <input type='text' id='username' name='username' placeholder='Enter your username'>
                </div>
                <div class='form-group'>
                    <label for='password'>Password</label>
                    <input type='password' id='password' name='password' placeholder='Enter your password'>
                </div>
                <button type='submit' class='save-button'>Save</button>
            </form>
        </div>
        <script src='scriptUsers.js'></script>
    </body>
    </html>";
?>