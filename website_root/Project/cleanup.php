<?php
$conn = mysqli_connect("localhost", "Sikander", "Sikander77", "feeder");
$result = mysqli_query($conn, "SELECT id, filename FROM system_logs WHERE filename != ''");

$count = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $path = "/home/Sikander/uploads/" . $row['filename'];
    if (!file_exists($path)) {
        mysqli_query($conn, "DELETE FROM system_logs WHERE id = " . $row['id']);
        $count++;
    }
}
echo "Done! Removed $count orphaned entries.";
?>