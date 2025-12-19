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
           

           if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $search = $_GET['search'];
           $ip = $_SERVER["REMOTE_ADDR"];

            // Insert into the database
            $sql = "INSERT INTO wsfinal (typed, ipadress) VALUES ('$search', '$ip')";
           mysqli_query($conn, $sql);

           }
            
           

            mysqli_close($conn);

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $serc = $_GET['search'];
         if (!headers_sent()) {
         header("Location: https://www.google.com/search?q=$serc");
         exit;
         }
        }
?>
</head>
<html>
    <body>
    </body>
</html>