<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect("localhost", "Sikander", "Sikander77", "feeder");

if (!$conn) {
    die("DB error: " . mysqli_connect_error());
}

$result = mysqli_query($conn, "SELECT * FROM system_logs ORDER BY id DESC LIMIT 1");

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo json_encode([
        "bird" => 0,
        "tray" => "NO DATA",
        "bin" => "NO DATA",
        "battery" => 0,
        "filename" => "",
        "time" => "NO DATA"
    ]);
    exit;
}

echo json_encode([
    "bird" => $row['bird'],
    "tray" => $row['tray_status'],
    "bin" => $row['bin_status'],
    "battery" => $row['battery'],
    "filename" => $row['filename'],   // ✅ THIS FIXES IT
    "time" => $row['timestamp']
]);

?>