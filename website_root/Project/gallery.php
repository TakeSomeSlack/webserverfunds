<?php

$conn = mysqli_connect("localhost", "Sikander", "Sikander77", "feeder");

$result = mysqli_query($conn, "SELECT * FROM system_logs WHERE filename LIKE '%.mp4' ORDER BY id DESC");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Video Gallery</title>
    <style>
        body { background-color: lightblue; text-align: center; }
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        video { width: 100%; }
        .card {
            background: white;
            padding: 10px;
            border-radius: 10px;
        }
    </style>
</head>

<body>

<h1>🎥 Bird Video Gallery</h1>
<a href="index.html">⬅ Back</a>

<div class="gallery">

<?php
while ($row = mysqli_fetch_assoc($result)) {

    $file = $row['filename'];
    $time = $row['timestamp'];

    echo "
    <div class='card'>
        <p>$time</p>
        <video controls>
            <source src='/uploads/$file' type='video/mp4'>
        </video>
    </div>
    ";
}
?>

</div>

</body>
</html>