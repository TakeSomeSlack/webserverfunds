<?php
 
header('Content-Type: application/json');
 
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['filename'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
    exit;
}
 
$filename = basename($_POST['filename']); // basename() prevents directory traversal attacks
 
// Only allow .mp4 files
if (!preg_match('/\.mp4$/i', $filename)) {
    echo json_encode(['success' => false, 'error' => 'Invalid file type']);
    exit;
}
 
$conn = mysqli_connect("localhost", "Sikander", "Sikander77", "feeder");
 
if (!$conn) {
    echo json_encode(['success' => false, 'error' => 'DB connection failed']);
    exit;
}
 
// Delete the database record
$stmt = mysqli_prepare($conn, "DELETE FROM system_logs WHERE filename = ?");
mysqli_stmt_bind_param($stmt, "s", $filename);
mysqli_stmt_execute($stmt);
 
// Delete the actual file from disk
$filepath = "/var/www/html/uploads/" . $filename; // adjust this path to match your server
 
if (file_exists($filepath)) {
    unlink($filepath);
}
 
mysqli_close($conn);
 
echo json_encode(['success' => true]);
?>