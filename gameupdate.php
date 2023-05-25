<?php
$card5 = 0;
$username = $_POST["name"];
$username = substr($username, 0, -5);
$roomnumber = $_POST["room"];
$file = "../room/".$roomnumber."card.txt";
$cardpack = json_decode(file_get_contents($file));
$start = $_POST["start"];
$stage = file_get_contents("../room/".$roomnumber."stage.txt", FILE_SKIP_EMPTY_LINES);
$stage3card = rtrim(file_get_contents("../room/$roomnumber"."stage.txt"), "\n");
if($start == 0)
{
  $response = str_replace("\n", "-", file_get_contents("../room/".$roomnumber.".txt"));
  echo $response;
}
else if($start == 1)
{
$filename = "../room/".$roomnumber.".txt";
$file = fopen($filename, "r+");
if ($file) 
{
    $lastline = "";
    while (($line = fgets($file)) !== false) {
        $lastline = $line;
    }
    if (strpos($lastline, "1111") === false) {
        fwrite($file, "1");
        fclose($file);
    }
    else if (strpos($lastline, "1111") === 0)
    {
      fclose($file);
      //maingame
      $filename = "../room/".$roomnumber.".txt";
      $file = fopen($filename, "r");
      if ($file) 
      {
        $firstLine = fgets($file);
        fclose($file);
        if (strpos($firstLine,$username) == 0) 
        {
        //chuphong
        if($stage == "1")
        {
          $file = "../room/".$roomnumber.".txt";
          $lines = file($file);
          $cardfile = "../room/".$roomnumber."card.txt";
          $cardcontent = file_get_contents($cardfile);
          foreach ($lines as $key => $line)
          {
            if (strpos($line,"1111") == false) 
            {
              $card1 = $cardpack[array_rand($cardpack)];
              $card2 = $cardpack[array_rand($cardpack)];
              $line = str_replace("\n", ":$card1:$card2:\n", $line);
              $lines[$key] = $line;
              $cardcontent = str_replace("\"$card1\",", "", $cardcontent);
              $cardcontent = str_replace("\"$card2\",", "", $cardcontent);
            }
          }
          file_put_contents($file, implode("", $lines));
          file_put_contents($cardfile, $cardcontent);
          $file = "../room/".$roomnumber.".txt";
          $lines = file($file);
          foreach ($lines as $line)
          {
            if (strpos($line, $username) == 0) 
            {
              echo $line;
              break;
            }
          }
          $filename = "../room/".$roomnumber."stage.txt";
          file_put_contents($filename, "2");
          $stage = "2";
        }
        else if($stage == "2")
        {
          $allnull = 1;
          foreach(file("../room/".$roomnumber.".txt") as $line) 
          {
            $array = explode(":", $line);
            if($line == "1111")
            {
              $nextplayer = 0;
              $line = explode(":", fgets(fopen("../room/".$roomnumber.".txt", "r")));
              $line[3] = 30;
              file_put_contents("../room/".$roomnumber.".txt", implode(":", $line));
              file_put_contents("../room/".$roomnumber."stage.txt", "3");
              break;
            }
            else if($array[3] != null)
            {
              $allnull = 0;
              if($array[3] != "1")
              {
                if($nextplayer == 1)
                {
                  $line = str_replace($array[3], "30", $line);
                  file_put_contents("../room/".$roomnumber.".txt", $line);
                  $nextplayer = 0;
                }
                else 
                {
                  $line = str_replace($array[3], strval(intval($array[3]) - 1), $line);
                  file_put_contents("../room/".$roomnumber.".txt", $line);
                }
              }
              else if($array[3] == "1")
              {
                $line = str_replace($array[3], null, $line);
                $line = str_replace($array[4], "fold", $line);
                file_put_contents("../room/".$roomnumber.".txt", $line);
                $nextplayer = 1;
              }
              break;
            }
            else 
            {
              if($nextplayer == 1)
                {
                  $line = str_replace($array[3], "30", $line);
                  file_put_contents("../room/".$roomnumber.".txt", $line);
                  $nextplayer = 0;
                }
                break;
            }
          }
          if($allnull == 1)
          {
            $line = explode(":", fgets(fopen("../room/".$roomnumber.".txt", "r")));
            $line[3] = 30;
            file_put_contents("../room/".$roomnumber.".txt", implode(":", $line));
          }
          //echo
          $echo = "";
          foreach(file("../room/".$roomnumber.".txt") as $line) 
          {
            $array = explode(":", $line);
            if ($array[0] != $username)
            {
              $array[1] = null;
              $array[2] = null;
            }
              $echo .= implode(":", $array) . "-";
          }
          echo $echo;
        }
        else if($stage == "3")
        {
          if ($stage3card != "1" && $stage3card != "2" && $stage3card != "3" && $stage3card != "4") {
          $card1 = $cardpack[array_rand($cardpack)];
          $card2 = $cardpack[array_rand($cardpack)];
          $card3 = $cardpack[array_rand($cardpack)];
          $cardcontent = str_replace("\"$card1\",", "", $cardcontent);
          $cardcontent = str_replace("\"$card2\",", "", $cardcontent);
          $cardcontent = str_replace("\"$card3\",", "", $cardcontent);
          file_put_contents($cardfile, $cardcontent);
          $dcard = $card1.":".$card2.":".$card3;
          file_put_contents("../room/".$roomnumber."stage.txt", $dcard.PHP_EOL, FILE_APPEND);

          echo $card1.":".$card2.":".$card3.":"."stage3";
          }
          else
          {
            $allnull = 1;
          foreach(file("../room/".$roomnumber.".txt") as $line) 
          {
            $array = explode(":", $line);
            if($line == "1111")
            {
              $nextplayer = 0;
              $line = explode(":", fgets(fopen("../room/".$roomnumber.".txt", "r")));
              $line[3] = 30;
              file_put_contents("../room/".$roomnumber.".txt", implode(":", $line));
              file_put_contents("../room/".$roomnumber."stage.txt", "4");
              break;
            }
            else if($array[3] != null)
            {
              $allnull = 0;
              if($array[3] != "1")
              {
                if($nextplayer == 1)
                {
                  $line = str_replace($array[3], "30", $line);
                  file_put_contents("../room/".$roomnumber.".txt", $line);
                  $nextplayer = 0;
                }
                else 
                {
                  $line = str_replace($array[3], strval(intval($array[3]) - 1), $line);
                  file_put_contents("../room/".$roomnumber.".txt", $line);
                }
              }
              else if($array[3] == "1")
              {
                $line = str_replace($array[3], null, $line);
                $line = str_replace($array[4], "fold", $line);
                file_put_contents("../room/".$roomnumber.".txt", $line);
                $nextplayer = 1;
              }
              break;
            }
            else 
            {
              if($nextplayer == 1)
                {
                  $line = str_replace($array[3], "30", $line);
                  file_put_contents("../room/".$roomnumber.".txt", $line);
                  $nextplayer = 0;
                }
                break;
            }
          }
          if($allnull == 1)
          {
            $line = explode(":", fgets(fopen("../room/".$roomnumber.".txt", "r")));
            $line[3] = 30;
            file_put_contents("../room/".$roomnumber.".txt", implode(":", $line));
          }
          //echo
          $echo = "";
          foreach(file("../room/".$roomnumber.".txt") as $line) 
          {
            $array = explode(":", $line);
            if ($array[0] != $username)
            {
              $array[1] = null;
              $array[2] = null;
            }
              $echo .= implode(":", $array) . "-";
          }
          echo $echo;
          }
        }
        else if($stage == "4")
        {
          $array = explode(":", $stage3card);
          if ($card5 == 1 || $array[3] == null) {
          $card1 = $cardpack[array_rand($cardpack)];
          $cardcontent = str_replace("\"$card1\",", "", $cardcontent);
          file_put_contents($cardfile, $cardcontent);
          $card1 = ":".$card1;
          $filename = "../room/" . $roomnumber . "stage.txt";
         file_put_contents($filename, $card1 . PHP_EOL, FILE_APPEND);
          }
          else
          {
            $allnull = 1;
          foreach(file("../room/".$roomnumber.".txt") as $line) 
          {
            $dealercards = explode(":", $line);
            if($line == "1111")
            {
              $card5 = 1;
              if($dealercards[4] != null)
              {
//đeohieucailongi
function compareHands($hand1, $hand2) {

  // Get the ranks of the cards in each hand.
  $ranks1 = getRanks($hand1);
  $ranks2 = getRanks($hand2);

  // Sort the ranks in each hand.
  sort($ranks1);
  sort($ranks2);

  // Compare the ranks of the hands.
  for ($i = 0; $i < count($ranks1); $i++) {
    if ($ranks1[$i] > $ranks2[$i]) {
      return 1;
    } else if ($ranks1[$i] < $ranks2[$i]) {
      return -1;
    }
  }

  // If the ranks of the hands are the same, compare the suits of the hands.
  $suits1 = getSuits($hand1);
  $suits2 = getSuits($hand2);

  // Sort the suits in each hand.
  sort($suits1);
  sort($suits2);

  // Compare the suits of the hands.
  for ($i = 0; $i < count($suits1); $i++) {
    if ($suits1[$i] > $suits2[$i]) {
      return 1;
    } else if ($suits1[$i] < $suits2[$i]) {
      return -1;
    }
  }

  // The hands are equal.
  return 0;
}

// Open the file.
$file = fopen("../room/$roomnumber.txt", "r");

// Create an array of players.
$players = array();

// Read each line of the file.
while (($line = fgets($file)) !== false) {

  // Split the line into an array.
  $parts = explode(":", $line);

  // Create a new player object.
  $player = new Player();

  // Set the player's name.
  $player->name = $parts[0];

  // Set the player's cards.
  $player->cards = $parts[1] . ":" . $parts[2];

  // Set the player's action.
  $player->action = $parts[3];

  // Set the player's bet.
  $player->bet = $parts[4];

  // Add the player to the list of players.
  if($player->action !== "fold"){
    $players[] = $player;
  }
}

// Get the dealer's cards.
$dealerCards = $dealercards;

// Combine the dealer's cards with each player's cards.
foreach ($players as $player) {
  $player->cards = $player->cards . ":" . implode(":", $dealerCards);
}

// Sort the players by hand value.
usort($players, function($a, $b) {
  return compareHands($a->cards, $b->cards);
});

// Print the winners.
$count = 0;
foreach ($players as $player) {
  if ($player->action !== "fold") {
    $count++;
  }
}
$winner = "";
foreach ($players as $player) {
  if($count > 1)
  {
    $count = $count / 2;
  }
  $winner .= "[".$player->name . ", gain: " . $player->bet . " x ".$count.", hand: " . $player->hand;
  $path = "../account/";
  $username = $player->name;
// Get all the files in the folder.
$files = scandir($path);

// Iterate over the files.
foreach ($files as $file) {

  // Check if the file name includes the username.
  if (strpos($file, $username) !== false) {

    // The file name includes the username.
    if(strpos($file, "txt") == false)
    {
      $file .= ".txt";
    }
      $path = "../account/".$file;

  }

}
  

// Open the file.
$file = fopen($path, "r");

// Read the content of the file.
$content = fread($file, filesize($path));

// Close the file.
fclose($file);

// Convert the content to an integer.
$content = intval($content);

// Multiply the content by the count.
$newContent = $content * $count;

// Write the new content to the file.
file_put_contents($path, $newContent);

}
file_put_contents("../room/$roomnumber "."stage.txt", "");

// Write the winner to the file.
file_put_contents("../room/$roomnumber"."stage.txt", $winner);
echo $winner."BẤM START ĐỂ RESTART ";
// Close the file.
fclose($file);
//hetdoandeohieu
              }
              break;
            }
            else if($array[3] != null)
            {
              $allnull = 0;
              if($array[3] != "1")
              {
                if($nextplayer == 1)
                {
                  $line = str_replace($array[3], "30", $line);
                  file_put_contents("../room/".$roomnumber.".txt", $line);
                  $nextplayer = 0;
                }
                else 
                {
                  $line = str_replace($array[3], strval(intval($array[3]) - 1), $line);
                  file_put_contents("../room/".$roomnumber.".txt", $line);
                }
              }
              else if($array[3] == "1")
              {
                $line = str_replace($array[3], null, $line);
                $line = str_replace($array[4], "fold", $line);
                file_put_contents("../room/".$roomnumber.".txt", $line);
                $nextplayer = 1;
              }
              break;
            }
            else 
            {
              if($nextplayer == 1)
                {
                  $line = str_replace($array[3], "30", $line);
                  file_put_contents("../room/".$roomnumber.".txt", $line);
                  $nextplayer = 0;
                }
                break;
            }
          }
          if($allnull == 1)
          {
            $line = explode(":", fgets(fopen("../room/".$roomnumber.".txt", "r")));
            $line[3] = 30;
            file_put_contents("../room/".$roomnumber.".txt", implode(":", $line));
          }
          //echo
          $echo = "";
          foreach(file("../room/".$roomnumber.".txt") as $line) 
          {
            $array = explode(":", $line);
            if ($array[0] != $username)
            {
              $array[1] = null;
              $array[2] = null;
            }
              $echo .= implode(":", $array) . "-";
          }
          echo $echo;
          }
        }
        }
        else
        {
        //khach
        if($stage === "1")
        {
          $file = "../room/".$roomnumber.".txt";
          $lines = file($file);
          foreach ($lines as $line)
          {
            if (strpos($line, $username) == 0) 
            {
              echo $line."1";
              break;
            }
          }
        }
        else if($stage === "2")
        {
          //echo
          $echo = "";
          foreach(file("../room/".$roomnumber.".txt") as $line) 
          {
            $array = explode(":", $line);
            if ($array[0] != $username)
            {
              $array[1] = null;
              $array[2] = null;
            }
              $echo .= implode(":", $array) . "-";
          }
          echo $echo;
        }
        else if($stage === "3")
        {
           if ($stage3card != "1" && $stage3card != "2" && $stage3card != "3" && $stage3card != "4") {
               echo $stage3card.":stage3";
            }
            else {
              //echo
           $echo = "";
          foreach(file("../room/".$roomnumber.".txt") as $line) 
          {
            $array = explode(":", $line);
            if ($array[0] != $username)
            {
              $array[1] = null;
              $array[2] = null;
            }
              $echo .= implode(":", $array) . "-";
          }
          echo $echo;
            }
        }
        else if($stage == "4")
        {
       


// Get the path to the file.
$path = "../room/$roomnumber"."stage.txt";

// Open the file.
$file = fopen($path, "r");

// Read the content of the file.
$content = fread($file, filesize($path));

// Close the file.
fclose($file);
if(strpos($content, "hand") != false)
{
// Echo the content of the file.
echo $content."ĐỢI CHỦ PHÒNG RESTART";
}
else
{
   if ($stage3card != "1" && $stage3card != "2" && $stage3card != "3" && $stage3card != "4") {
               echo $stage3card.":stage3";
            }
            else {
              //echo
           $echo = "";
          foreach(file("../room/".$roomnumber.".txt") as $line) 
          {
            $array = explode(":", $line);
            if ($array[0] != $username)
            {
              $array[1] = null;
              $array[2] = null;
            }
              $echo .= implode(":", $array) . "-";
          }
          echo $echo;
            }
}
        }
        }
      }
    }
}
}
?>