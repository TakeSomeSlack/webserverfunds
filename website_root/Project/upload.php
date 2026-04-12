<?php 

$server = "localhost";
$username = "sikanderphp";
$password = "Sikander77";
$database = "feeder";

$conn = mysqli_connect($server, $username, $password, $database);

if (!$conn) {
    die("connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = $_POST['data'];

    // Convert: B:1,T:OK,N:OK,BAT:85
    $data = str_replace(",", "&", $data);
    parse_str($data, $parsed);

    $bird = $parsed['B'];
    $tray = $parsed['T'];
    $bin = $parsed['N'];
    $battery = $parsed['BAT'];

    $filename = "";

    // ✅ UPDATED PATH HERE
    if (isset($_FILES['video'])) {
        $target_dir = "/home/Sikander/uploads/";

        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $filename = time() . "_" . basename($_FILES["video"]["name"]);
        move_uploaded_file($_FILES["video"]["tmp_name"], $target_dir . $filename);
    }

    $sql = "INSERT INTO system_logs (bird, tray_status, bin_status, battery, filename)
            VALUES ('$bird', '$tray', '$bin', '$battery', '$filename')";

    mysqli_query($conn, $sql);

    echo "OK";
}
?>