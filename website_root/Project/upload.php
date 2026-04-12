<?php

$conn = mysqli_connect("localhost", "Sikander", "Sikander77", "feeder");

$target_dir = "/home/Sikander/uploads/";

if (isset($_FILES["video"])) {

    $filename = basename($_FILES["video"]["name"]);
    $h264_path = $target_dir . $filename;

    if (move_uploaded_file($_FILES["video"]["tmp_name"], $h264_path)) {

        echo "UPLOAD OK: " . $filename . "\n";

        // Convert to MP4
        $mp4_name = pathinfo($filename, PATHINFO_FILENAME) . ".mp4";
        $mp4_path = $target_dir . $mp4_name;

        $cmd = "ffmpeg -i $h264_path -c:v libx264 -pix_fmt yuv420p $mp4_path 2>&1";
        shell_exec($cmd);

        // Save to DB
        mysqli_query($conn, "
            INSERT INTO system_logs (bird, tray_status, bin_status, battery, filename)
            VALUES (1, 'OK', 'OK', 100, '$mp4_name')
        ");

        // Optional: delete raw file
        unlink($h264_path);

        echo "CONVERTED TO: " . $mp4_name;

    } else {
        echo "UPLOAD FAILED";
    }

} else {
    echo "NO FILE RECEIVED";
}

?>