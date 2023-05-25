<?php
$dir = "../room";
$files = scandir($dir);
$files = array_diff($files, array('.', '..'));
foreach ($files as $file) {
    $file = preg_replace('/\\.[^.\\s]{3,4}$/', '.', $file);
    echo $file;
}
?>
