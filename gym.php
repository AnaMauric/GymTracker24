
<?php echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>New Workout</title>
    <link rel='stylesheet' href='styles.css'>
</head>
<body onload='getvariables(); return false'>

    <a href='home.php' class='home-button'>Home</a>
    <div class='container'>
        <h1>New Workout</h1>
        <form  onsubmit='handleForm(event)'>
            <div class='form-group'>
                <label for='exercise-name'>Exercise Name</label>
                <select id='exercise-name' name='exercise_name' required>
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
            </div>
            <div class='form-group'>
                <label for='weight'>Weight</label>
                <input type='number' id='weight' name='weight'  step='0.01' required>
            </div>
            <div class='form-group'>
                <label for='sets'>Sets</label>
                <input type='number' id='sets' name='sets' required>
            </div>
            <div class='form-group'>
                <label for='reps'>Reps</label>
                <input type='text' id='reps' name='reps' required>
            </div>
            <button type='submit' class='save-button'>Save</button>
        </form>
    </div>
    
    
    <div id='scrollable-div'>
    <table id='data-table'>
        <thead>
            <tr>
                <th>Date</th>
                <th>Exercise name</th>
                <th>Weight</th>
                <th>Sets</th>
                <th>Reps</th>
            </tr>
        </thead>
        <tbody>
            <!-- Vrstice bodo dinamično dodane tukaj -->
        </tbody>
    </table>
    </div>


    <div class='container'>
        <h1>Delete Workout</h1>
        <form  onsubmit='handleFormDelete(event)'>
            <div class='form-group'>
                <label for='exercise-name'>Exercise Name</label>
                    <select id='exercise-delete' name='exercise_delete' required>
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
            </div>
            <div class='form-group'>
                <label for='dat'>Pick a Date:</label>
                <input type='date' id='dat' name='dat'>
            </div>
            <button type='submit' class='save-button'>Delete</button>
        </form>
    </div>

    <script src='scriptExercises.js'></script>
</body>
</html>";
?>