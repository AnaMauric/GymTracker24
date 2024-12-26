
<?php echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>New Workout</title>
    <link rel='stylesheet' href='styles.css'>
</head>
<body onload='getvariables(); return false'>
    <div class='container'>
        <h1>New Workout</h1>
        <form  onsubmit='handleForm(event)'>
            <div class='form-group'>
                <label for='exercise-name'>Exercise Name</label>
                <input type='text' id='exercise-name' name='exercise_name' required>
            </div>
            <div class='form-group'>
                <label for='weight'>Weight</label>
                <input type='number' id='weight' name='weight' required>
            </div>
            <div class='form-group'>
                <label for='sets'>Sets</label>
                <input type='number' id='sets' name='sets' required>
            </div>
            <div class='form-group'>
                <label for='reps'>Reps</label>
                <input type='number' id='reps' name='reps' required>
            </div>
            <button type='submit' class='save-button'>Save</button>
        </form>
    </div>
    <script src='scriptExercises.js'></script>
</body>
</html>";
?>