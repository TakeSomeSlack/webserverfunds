<?php

$file = __DIR__ . "/command.txt";

if (!file_exists($file)) {
    echo "NONE";
    exit;
}

$cmd = file_get_contents($file);
file_put_contents($file, "NONE");

echo trim($cmd);
?>