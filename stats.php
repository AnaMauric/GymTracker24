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
    <input type='text' id='exercise' placeholder='Enter exercise'>
      <button id='submitButton' class='save-button'>Submit</button>
    </div>
    <div>
      <canvas id='weightChart' width='500' height='500'></canvas>
    </div>
    <script src='scriptStats.js'></script>
</body>
</html>";  
?>