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
  <h1>Weight Progress Chart</h1>
    <canvas id='weightChart' width='150' height='150'></canvas>
  <div>
  <input type='text' id='exercise' placeholder='Enter exercise'>
    <button id='submitButton'>Submit</button>
  </div>
  <script src='scriptStats.js'></script>
</body>
</html>";  
?>