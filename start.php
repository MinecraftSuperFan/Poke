<?php
$roomnumber = $_GET["room"];
$file = "../room".$roomnumber.".txt";
$content = file_get_contents($file);
$lines = explode("\n", $content);
if (end($lines) == "1") {
    echo "1";
}
$file_path = "../room/" . $roomnumber."stage.txt";
unlink($file_path);
$file_content = "1";
$file = fopen($file_path, "w");
fwrite($file, $file_content);
fclose($file);
?>