<?php

$conn = mysqli_connect("localhost", "Sikander", "Sikander77", "feeder");

if (!$conn) {
    die("DB error");
}

$result = mysqli_query($conn, "SELECT * FROM system_logs ORDER BY id DESC LIMIT 1");

$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo json_encode([
        "bird" => 0,
        "tray" => "N/A",
        "bin" => "N/A",
        "battery" => 0,
        "filename" => "",
        "time" => "No data"
    ]);
    exit;
}

echo json_encode([
    "bird" => $row['bird'],
    "tray" => $row['tray_status'],
    "bin" => $row['bin_status'],
    "battery" => $row['battery'],
    "filename" => $row['filename'],
    "time" => $row['timestamp']
]);

?>