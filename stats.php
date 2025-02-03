<?php
echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Weight Progress Chart</title>
    <script src='https://cdn.jsdelivr.net/npm/chart.js'></script>
    <link rel='stylesheet' href='styles.css'>
</head>
<body>
    <a href='home.php' class='home-button'>Home</a>
    <div>
      <h1>Weight Progress Chart</h1>
      <label for='exercise'>Exercise Name</label>
                <select id='exercise' name='exercise' required>
                    <option value=''>-- Choose exercise --</option>
                    <option value='Squat'>Squat</option>
                    <option value='leg press'>leg press</option>
                    <option value='Biceps curls'>Biceps curls</option>
                    <option value='Bench press'>Bench press</option>
                    <option value='Deadlift'>Deadlift</option>
                    <option value='Pull-up'>Pull-up</option>
                </select>
      <button id='submitButton' class='save-button'>Submit</button>
    </div>
    <div>
      <canvas id='weightChart' width='500' height='500'></canvas>
    </div>
    <script src='scriptStats.js'></script>
</body>
</html>";  
?>