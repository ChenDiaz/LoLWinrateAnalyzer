<?php
     include 'jsonHelper.php';
     
     //Gets data from index.php
     $user = htmlspecialchars($_POST['user']);
     $duoPartner  = htmlspecialchars($_POST['duoPartner']);

     //Nested ifs check if you've entered a single username or two and gives the appropriate response
     if($user != ""){
          //Gets and prints user_id using jsonHelper
          $user_id = getSummonerId($user);
          echo $user_id . "<br>";

          //Same thing for duo partner
          if($duoPartner != ""){
               $duoPartner_id = getSummonerId($duoPartner);
               echo $duoPartner_id . "<br>";
          }

          //Gets user's match list using jsonHelper
          $userMatchList = getMatchList($user_id);

          //Using breaks like this can't be good practice haha
          echo "Your very last ranked match timestamp: " . $userMatchList["matches"][0]["timestamp"] . "<br><br>";

          $userMatchURL = "https://na.api.pvp.net/api/lol/na/v2.2/match/" . $userMatchList["matches"][0]["matchId"] . "?api_key=451d171b-aefb-4b11-ba80-212cbbcc9d79";
          $userMatchJSON = file_get_contents($userMatchURL);
          $userMatch = json_decode($userMatchJSON, true);

          //Need help with this on thursday morning if you're here.
          for($i = 0; $i < 10; $i++)
          {
               if($userMatch["participantIdentities"][$i]["player"]["summonerId"] == $user_id)
               {
                    $user_participant_id = $userMatch["participantIdentities"][$i]["participantId"];
               }
          }

          echo "<h1> Your ingame participant id was: " . $user_participant_id . "</h1>";
     }

     else{
          echo "<p>Try again but this time enter some usernames ;)</p>";
     }
?>