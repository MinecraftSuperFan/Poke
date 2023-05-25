<?php
$user = $_GET['username'];
$roomnumber = $_GET['room'];
$user = substr($user, 0, -5);
// Open file for reading and writing
$file = fopen("../room/$roomnumber.txt", "r+");

// Read file line by line
while (!feof($file)) {
    $line = fgets($file);

    // Check if line contains username
    if (strpos($line, $user) !== false) {
        // Delete line
        ftruncate($file, ftell($file) - strlen($line));
        break;
    }
}

// Close file
fclose($file);
?>