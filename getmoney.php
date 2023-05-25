<?php
$user = $_POST['user'];
$filename = "../account/".$user.".txt";

if (file_exists($filename)) {
    $file = fopen($filename, "r");
    echo fgets($file);
    fclose($file);
} else {
    $file = fopen($filename, "w");
    fwrite($file, "3000");
    echo "3000";
    fclose($file);
}
?>