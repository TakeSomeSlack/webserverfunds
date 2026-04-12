<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    file_put_contents("command.txt", $_POST['cmd']);
}
?>