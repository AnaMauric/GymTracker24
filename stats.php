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
      <h1>Exercise Progress Chart</h1>
        <label for='exercise'>Exercise Name</label>
                <select id='exercise' name='exercise' required>
                    <option value=''>-- Choose exercise --</option>
                    <option value='Assisted Pull-ups'>Assisted Pull-ups</option>
                    <option value='Back Squat'>Back Squat</option>
                    <option value='Bench press'>Bench press</option>
                    <option value='Biceps Curls'>Biceps Curls</option>
                    <option value='Deadlift'>Deadlift</option>
                    <option value='Hack Squat'>Hack Squat</option>
                    <option value='Hip Thrusts'>Hip Thrusts</option>
                    <option value='Shoulder Press'>Shoulder Press</option>
                    <option value='Triceps Rope Pull-downs'>Triceps Rope Pull-downs</option>
                </select>
      <button id='submitButton' class='save-button'>Submit</button>
    </div>
    <div>
      <canvas id='weightChart' width='500' height='500'></canvas>
    </div>
      <div>
        <h1>Body-weight Progress Chart</h1>
        <button id='getWeightButton' class='save-button'>Submit</button>
      </div>
    <div>
      <canvas id='weightChart2' width='500' height='500'></canvas>
    </div>
    <script src='scriptStats.js'></script>
</body>
</html>";  
?>