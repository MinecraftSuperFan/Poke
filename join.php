<?php
$username = $_GET['user'];
$roomnumber = $_GET['room'];
$username = substr($username, 0, -5);
$file = fopen("../room/".$roomnumber.".txt", "a+");
if (substr_compare(fgets($file), "1111", -4) !== 0) {
    fwrite($file, $username . "\n");
}
fclose($file);
?>