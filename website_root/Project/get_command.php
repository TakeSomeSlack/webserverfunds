<?php

$file = "command.txt";

if (!file_exists($file)) {
    echo "NONE";
    exit;
}

$cmd = trim(file_get_contents($file));

if ($cmd == "") {
    echo "NONE";
} else {
    echo $cmd;
    file_put_contents($file, "");
}

?>