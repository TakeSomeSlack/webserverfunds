<?php

$conn = mysqli_connect("localhost", "Sikander", "Sikander77", "feeder");

if (!$conn) {
    die("DB error: " . mysqli_connect_error());
}

$target_dir = "/home/Sikander/uploads/";


// ==========================
// HANDLE STATUS DATA
// ==========================
if (isset($_POST["data"])) {

    $data = $_POST["data"];

    if (preg_match('/B:(\d+),T:(\w+),N:(\w+),BAT:(\d+)/', $data, $matches)) {

        $bird = $matches[1];
        $tray = $matches[2];
        $bin = $matches[3];
        $battery = $matches[4];

        mysqli_query($conn, "
            INSERT INTO system_logs (bird, tray_status, bin_status, battery, filename)
            VALUES ($bird, '$tray', '$bin', $battery, '')
        ");

        echo "STATUS OK";
    } else {
        echo "INVALID STATUS FORMAT";
    }

    exit;
}


// ==========================
// HANDLE VIDEO UPLOAD
// ==========================
if (isset($_FILES["video"])) {

    $filename = basename($_FILES["video"]["name"]);
    $h264_path = $target_dir . $filename;

    if (move_uploaded_file($_FILES["video"]["tmp_name"], $h264_path)) {

        echo "UPLOAD OK: " . $filename . "\n";

        // CONVERT TO MP4
        $mp4_name = pathinfo($filename, PATHINFO_FILENAME) . ".mp4";
        $mp4_path = $target_dir . $mp4_name;

        $cmd = "ffmpeg -i $h264_path -c:v libx264 -pix_fmt yuv420p $mp4_path 2>&1";
        shell_exec($cmd);

        // SAVE VIDEO ENTRY
        mysqli_query($conn, "
            INSERT INTO system_logs (bird, tray_status, bin_status, battery, filename)
            VALUES (1, 'OK', 'OK', 100, '$mp4_name')
        ");

        // DELETE RAW FILE
        unlink($h264_path);

        echo "CONVERTED TO: " . $mp4_name;

    } else {
        echo "UPLOAD FAILED";
    }

    exit;
}

echo "NO DATA RECEIVED";

?>