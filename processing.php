
<?php
     /*
          **********************************************************************
          We may need to add some error handling in case Riot's api's goes down.
          **********************************************************************
     */
     include 'jsonHelper.php';
     
     //Gets data from index.php
     $user = htmlspecialchars($_POST['user']);
     $duoPartner  = htmlspecialchars($_POST['duoPartner']);

     //Nested ifs check if you've entered a single username or two and gives the appropriate response
     if($user != ""){
          //Gets and prints user_id using jsonHelper
          $user_id = getSummonerId($user);
          echo "Your user ID is: " . $user_id . "<br>";

          //Same thing for duo partner
          if($duoPartner != ""){
               $duoPartner_id = getSummonerId($duoPartner);
               echo "Your duo's ID is: " . $duoPartner_id . "<br><br>";
          }

          //Gets user's match list using jsonHelper
          $userMatchList = getMatchList($user_id);

          //Using breaks like this can't be good practice haha
          echo "Your very last ranked match timestamp: " . $userMatchList["matches"][0]["timestamp"] . "<br><br>";

          $userMatchURL = "https://na.api.pvp.net/api/lol/na/v2.2/match/" . $userMatchList["matches"][0]["matchId"] . "?api_key=451d171b-aefb-4b11-ba80-212cbbcc9d79";
          $userMatchJSON = file_get_contents($userMatchURL);
          $userMatch = json_decode($userMatchJSON, true);

          //Need help with this on thursday morning if you're here.
          //(Scott) looks fine to me
          for($i = 0; $i < 10; $i++)
          {
               if($userMatch["participantIdentities"][$i]["player"]["summonerId"] == $user_id)
               {
                    // the user is one of summoners 1-10
                    $user_participant_id = $userMatch["participantIdentities"][$i]["participantId"];
               }
          }

          echo "<h1> Your ingame participant id was: " . $user_participant_id . "</h1>";

          //Figure out what champion the user was playing
          $championId = $userMatch["participants"][$user_participant_id - 1]["championId"];
          $championName = getChampionName($championId);
          echo "<h1> You were playing " . $championName . "!</h1>";

          //Now we figure out if our $user has won the game or not
          // Side note: Since $user_participant_id is 1-10, subtracting one is necessary to get the right index
          $userWonMatch = $userMatch["participants"][$user_participant_id - 1]["stats"]["winner"];
          $victoryString = ($userWonMatch) ? "won": "lost";
          echo "<h1> You " . $victoryString . " the match! </h1>";
     }

     else{
          echo "<p>Try again but this time enter some usernames ;)</p>";
     }
?>