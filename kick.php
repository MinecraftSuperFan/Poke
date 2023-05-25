<?php
$last_line = trim(`tail -n 1 ../room/{$roomnumber}.txt`);
$player = $_GET['p'];
$username = $_GET['name'];
$filename = "../room/".$roomnumber.".txt";
if(substr_compare($last_line, "1111", -4) !== 0)
{
$file = file($filename);
foreach ($file as $line) {
    if (strpos($username, $line) !== false) {
        $key = array_search($line, $file);
        unset($file[$key]);
    }
    else
    {
      echo "bạn đéo phải chủ phòng";
    }
}

file_put_contents($filename, implode("", $file));
echo "kick thành công user: ".$player;
}
else {
  echo "trò chơi đã bắt đầu không thể kick";
}
?>