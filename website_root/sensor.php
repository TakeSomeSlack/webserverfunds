<!DOCTYPE html>
<html>
<head>
    <title>BME280 Readings</title>
</head>
<body>

<h2>BME280 Sensor Readings</h2>

<form method="post">
    <button type="submit" name="read">Read Sensor</button>
</form>

<?php
if (isset($_POST['read'])) {

    // Run your compiled binary
    $raw = `./bme280`;

    // Convert JSON output into a PHP array
    $deserialized = json_decode($raw, true);

    // Display readings
    echo "<p>Temperature: " . $deserialized["temperature"] . "</p>";
    echo "<p>Pressure: " . $deserialized["pressure"] . "</p>";
    echo "<p>Altitude: " . $deserialized["altitude"] . "</p>";
}
?>

</body>
</html>