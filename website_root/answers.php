<!DOCTYPE html>
<head>
    <?php
            // Retrieve submitted information
            $who = htmlspecialchars($_POST["hollow_knight"]); 
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
        ?>
</head>
<html>
    <body>
        <p>who got you on the game: <?= htmlspecialchars($_POST['who'])?> </p>
        <p>Favorite boss: <?= htmlspecialchars($_POST['favboss'])?> </p>
        <p>worst boss: <?= htmlspecialchars($_POST['worstboss'])?> </p>
        <p>Hours on the game: <?= htmlspecialchars($_POST['hours'])?> </p>
        <p>How hyped you are: <?= htmlspecialchars($_POST['hypelevel'])?> </p>
    </body>
</html>