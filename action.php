<?php
$username = $_GET['user'];
$username = substr($username, 0, -5);
$roomnumber = $_GET['room'];
$action = $_GET['action'];
$previousline = "";
foreach (file("../room/".$roomnumber.".txt") as $line) {
    if (strpos($line, $username) !== false) {
        $result = explode(":", $line);
        break;
    }
    $pl = explode(":",$line);
}
if($result[4] != "fold")
{
if($result[3] != null)
{
  $dir = "../account/";
  $files = scandir($dir);
  foreach ($files as $file) {
    if (strpos($file, $username) !== false && pathinfo($file, PATHINFO_EXTENSION) == "txt") {
        $money = file_get_contents($dir . $file);
        break;
    }
  }
  if($action == "bet")
  {
    foreach (file("../room/".$roomnumber.".txt") as &$line) {
       if (strpos($line, $username) !== false) {
            $fields = explode(":", $line);
            if($money <= (int)$fields[5] + 200)
            {
              echo "hết tiền";
            }
            else 
            {
            if($pl[5] == null)
            {
            $fields[5] = 200;
            echo "bet";
            }
            else 
            {
            $fields[5] = (int)$fields[5] + 200;
            $fields[5] = (string)$fields[5];
            echo "bet";
            }
            $line = implode(":", $fields);
            }
        }
    }
    file_put_contents($file, implode("\n", $lines));
  }
  else if($action == "raise")
  {
    foreach (file("../room/".$roomnumber.".txt") as &$line) {
       if (strpos($line, $username) !== false) {
            $fields = explode(":", $line);
            if($money < (int)$fields[5] * 2)
            {
              echo "hết tiền";
            }
            else
            {
            if($pl[5] == null)
            {
            $fields[5] = 200;
            echo "raise";
            }
            else 
            {
            $fields[5] = (int)$fields[5] * 2;
            $fields[5] = (string)$fields[5];
            echo "raise";
            }
            $line = implode(":", $fields);
            }
        }
    }
    file_put_contents($file, implode("\n", $lines));
  }
  else if($action == "fold")
  {
    foreach (file("../room/".$roomnumber.".txt") as &$line) {
       if (strpos($line, $username) !== false) {
            $fields = explode(":", $line);
            $fields[4] = "fold";
            $line = implode(":", $fields);
            echo "fold";
        }
    }
    file_put_contents($file, implode("\n", $lines));
  }
  else if($action == "check")
  {
    foreach (file("../room/".$roomnumber.".txt") as &$line) {
       if (strpos($line, $username) !== false) {
            $fields = explode(":", $line);
            if($pl[4] == "check")
            {
            $fields[4] = "check";
            $line = implode(":", $fields);
            echo "check";
            }
            else
            {
              echo "bạn phải đặt cược";
            }
        }
    }
    file_put_contents($file, implode("\n", $lines));
  }
}
else 
{
  echo "0";
}
}
else
{
  echo "fold";
}
?>