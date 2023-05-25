<?php
$random_number = rand(10000, 99999);
$file_name = $random_number . ".txt";
$file_path = "../room/" . $file_name;
$file_content = substr($_POST['user'],0,-5) . "\n";
$file = fopen($file_path, "w");
fwrite($file, $file_content);
fclose($file);
$file_name = $random_number."stage".".txt";
$file_path = "../room/" . $file_name;
$file_content = "1";
$file = fopen($file_path, "w");
fwrite($file, $file_content);
fclose($file);
$cardpack = '["clubs_10", "clubs_2", "clubs_3", "clubs_4", "clubs_5", "clubs_6", "clubs_7", "clubs_8", "clubs_9", "clubs_ace", "clubs_jack", "clubs_king", "clubs_queen", "diamonds_10", "diamonds_2", "diamonds_3", "diamonds_4", "diamonds_5", "diamonds_6", "diamonds_7", "diamonds_8", "diamonds_9", "diamonds_ace", "diamonds_jack", "diamonds_king", "diamonds_queen", "hearts_10", "hearts_2", "hearts_3", "hearts_4", "hearts_5", "hearts_6", "hearts_7", "hearts_8", "hearts_9", "hearts_ace", "hearts_jack", "hearts_king", "hearts_queen", "spades_10", "spades_2", "spades_3", "spades_4", "spades_5", "spades_6", "spades_7", "spades_8", "spades_9", "spades_ace", "spades_jack", "spades_king", "spades_queen"]';
$file_path = "../room/" . $random_number . "card.txt";
$file = fopen($file_path, "w");
fwrite($file, $cardpack);
fclose($file);
echo strval($random_number);
?>