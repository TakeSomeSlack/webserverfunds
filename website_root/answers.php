<!DOCTYPE html>
<head>
    <?php
            // Retrieve submitted information
            $server = "localhost";
            $username = "sikanderphp";
            $password = "Sikander77";
            $database = "experience";
            $conn = mysqli_connect($server, $username, $password, $database);
            
            // Check for successful connection
            if (!$conn) {
              die("Connection failed: {mysqli_connect_error()}");
            }
            $sql = "select course_name, num_students from courses where course_number='{$course_number}';";
            $result = mysqli_query($conn, $sql);

            $who = $_POST['who'];
            $favboss = $_POST['favboss'];
            $worstboss = $_POST['worstboss'];
            $hours = $_POST['hours'];
            $hypelevel = $_POST['hypelevel'];

            $sql = "INSERT INTO experiences (who_did, fav_boss, worst_boss, hours_on, hype_level)
            VALUES ('$who', '$favboss', '$worstboss', '$hours', '$hypelevel')";
        ?>
</head>
<html>
    <body>
        <h2>Your Hollow Knight Experience:</h2>
        <p>Who got you on the game: <?= $who ?></p>
        <p>Favorite boss: <?= $favboss ?></p>
        <p>Worst boss: <?= $worstboss ?></p>
        <p>Hours on the game: <?= $hours ?></p>
        <p>Hype level for Silksong: <?= $hypelevel ?></p>
    </body>
</html>