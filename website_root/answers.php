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
           

           if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $who = $_POST['who'];
            $favboss = $_POST['favboss'];
            $worstboss = $_POST['worstboss'];
            $hours = $_POST['hours'];
            $hypelevel = $_POST['hypelevel'];

            // Insert into the database
            $sql = "INSERT INTO hollow_knight (who_did, fav_boss, worst_boss, hours_on, hype_level)
            VALUES ('$who','$favboss','$worstboss','$hours','$hypelevel')";
            mysqli_query($conn, $sql);

            $sql_select = "SELECT * FROM hollow_knight WHERE who_did = '$who'";
            $result = mysqli_query($conn, $sql_select);

            echo "<h2>Previous entries for $who:</h2>";
            while ($row = mysqli_fetch_assoc($result)) {
            echo "Favorite boss: {$row['fav_boss']}<br/>";
             echo "Worst boss: {$row['worst_boss']}<br/>";
                echo "Hours: {$row['hours_on']}<br/>";
            echo "Hype level: {$row['hype_level']}<br/><br/>";
                }
           }
            mysqli_close($conn);
            $LED = 0;
            $output = shell_exec(gpio toggle $LED);
            echo $output;
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