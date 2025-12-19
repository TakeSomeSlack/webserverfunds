<!DOCTYPE html>
<head>
    <?php
            header("https://www.google.com");
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
            $search = $_POST['search'];
           // $ip = $_SERVER["REMOTE_ADDR"];

            // Insert into the database
            $sql = "INSERT INTO wsfinal (typed)
            VALUES ('$search')";
            mysqli_query($conn, $sql);

           }
            mysqli_close($conn);
            
?>
</head>
<html>
    <body>
        <p>what: <?= $search ?></p>
    </body>
</html>