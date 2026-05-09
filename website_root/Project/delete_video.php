<?php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['filename'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
    exit;
}

$filename = basename($_POST['filename']);

if (!preg_match('/\.mp4$/i', $filename)) {
    echo json_encode(['success' => false, 'error' => 'Invalid file type']);
    exit;
}

$conn = mysqli_connect("localhost", "Sikander", "Sikander77", "feeder");

if (!$conn) {
    echo json_encode(['success' => false, 'error' => 'DB connection failed']);
    exit;
}

// DELETE DB ENTRY
$stmt = mysqli_prepare($conn, "DELETE FROM system_logs WHERE filename = ?");
mysqli_stmt_bind_param($stmt, "s", $filename);
mysqli_stmt_execute($stmt);

// DELETE MP4
$filepath = "/home/Sikander/uploads/" . $filename;
if (file_exists($filepath)) unlink($filepath);

// DELETE THUMBNAIL
$thumb = "/home/Sikander/uploads/" . pathinfo($filename, PATHINFO_FILENAME) . ".jpg";
if (file_exists($thumb)) unlink($thumb);

mysqli_close($conn);

echo json_encode(['success' => true]);

?>