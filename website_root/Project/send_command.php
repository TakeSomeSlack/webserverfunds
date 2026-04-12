<?php

$file = __DIR__ . "/command.txt";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_POST['cmd'])) {
        echo "NO CMD";
        exit;
    }

    $cmd = $_POST['cmd'];

    file_put_contents($file, $cmd);

    echo "WROTE: " . $cmd;
}
?>