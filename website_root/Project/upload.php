<?php

$conn = mysqli_connect("localhost", "Sikander", "Sikander77", "feeder");

if (!$conn) {
    die("DB error: " . mysqli_connect_error());
}

$target_dir = "/home/Sikander/uploads/";


// ==========================
// CLEANUP ORPHANED ENTRIES
// ==========================
function cleanupOrphans($conn, $target_dir) {
    $result = mysqli_query($conn, "SELECT id, filename FROM system_logs WHERE filename != ''");
    while ($row = mysqli_fetch_assoc($result)) {
        $path = $target_dir . $row['filename'];
        if (!file_exists($path)) {
            mysqli_query($conn, "DELETE FROM system_logs WHERE id = " . $row['id']);
        }
    }
}


// ==========================
// HANDLE STATUS DATA
// ==========================
if (isset($_POST["data"])) {

    $data = $_POST["data"];

    if (preg_match('/B:(\d+),T:(\w+),N:(\w+),BAT:(\d+)/', $data, $matches)) {

        $bird    = (int)$matches[1];
        $tray    = mysqli_real_escape_string($conn, $matches[2]);
        $bin     = mysqli_real_escape_string($conn, $matches[3]);
        $battery = (int)$matches[4];

        mysqli_query($conn, "
            INSERT INTO system_logs (bird, tray_status, bin_status, battery, filename)
            VALUES ($bird, '$tray', '$bin', $battery, '')
        ");

        // clean up any orphaned DB entries silently in the background
        cleanupOrphans($conn, $target_dir);

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

    $filename  = basename($_FILES["video"]["name"]);
    $h264_path = $target_dir . $filename;

    if (move_uploaded_file($_FILES["video"]["tmp_name"], $h264_path)) {

        echo "UPLOAD OK: " . $filename . "\n";

        // CONVERT TO MP4
        $mp4_name = pathinfo($filename, PATHINFO_FILENAME) . ".mp4";
        $mp4_path = $target_dir . $mp4_name;

        $cmd = "ffmpeg -i " . escapeshellarg($h264_path) . " -c:v libx264 -pix_fmt yuv420p " . escapeshellarg($mp4_path) . " 2>&1";
        shell_exec($cmd);

        // GENERATE THUMBNAIL
        $thumb_name = pathinfo($filename, PATHINFO_FILENAME) . ".jpg";
        $thumb_path = $target_dir . $thumb_name;

        $thumb_cmd = "ffmpeg -i " . escapeshellarg($mp4_path) . " -ss 00:00:01 -vframes 1 -update 1 " . escapeshellarg($thumb_path) . " 2>&1";
        shell_exec($thumb_cmd);

        // UPDATE MOST RECENT ROW WITH FILENAME
        mysqli_query($conn, "
            UPDATE system_logs
            SET filename = '$mp4_name'
            WHERE filename = ''
            ORDER BY id DESC
            LIMIT 1
        ");

        // DELETE RAW H264 FILE
        unlink($h264_path);

        echo "CONVERTED TO: " . $mp4_name;

    } else {
        echo "UPLOAD FAILED";
    }

    exit;
}


// ==========================
// HANDLE WARNINGS
// ==========================
if (isset($_POST["warning"])) {

    $warning = $_POST["warning"];

    // get real current battery level from latest row
    $bat_result = mysqli_query($conn, "SELECT battery FROM system_logs ORDER BY id DESC LIMIT 1");
    $bat_row    = mysqli_fetch_assoc($bat_result);
    $battery    = $bat_row ? (int)$bat_row['battery'] : 0;

    if ($warning == "BIN_LOW") {
        mysqli_query($conn, "
            UPDATE system_logs
            SET bin_status = 'LOW'
            ORDER BY id DESC
            LIMIT 1
        ");
        echo "BIN WARNING STORED";
    }

    if ($warning == "BAT_LOW") {
        mysqli_query($conn, "
            UPDATE system_logs
            SET battery = $battery
            ORDER BY id DESC
            LIMIT 1
        ");
        echo "BAT WARNING STORED";
    }

    exit;
}


echo "NO DATA RECEIVED";

?>