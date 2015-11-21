
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
          $userId = getSummonerId($user);
          echo "Your user ID is: " . $userId . "<br>";

          //Same thing for duo partner
          if($duoPartner != ""){
               $duoPartnerId = getSummonerId($duoPartner);
               echo "Your duo's ID is: " . $duoPartnerId . "<br><br>";
          }

          //Gets user's match list using jsonHelper
          $userMatchList = getMatchList($userId);


          $matchWins = 0;
          for($i = 0; $i < 10; $i++)
          {
               $userMatchURL = "https://na.api.pvp.net/api/lol/na/v2.2/match/" . $userMatchList["matches"][$i]["matchId"] . "?api_key=451d171b-aefb-4b11-ba80-212cbbcc9d79";
               $userMatchJSON = file_get_contents($userMatchURL);
               $userMatch = json_decode($userMatchJSON, true);

               //Need help with this on thursday morning if you're here.
               //(Scott) looks fine to me?
               for($j = 0; $j < 10; $j++)
               {
                    if($userMatch["participantIdentities"][$j]["player"]["summonerId"] == $userId)
                    {
                         // the user is one of summoners 1-10
                         $userParticipantId = $userMatch["participantIdentities"][$j]["participantId"];
                    }
               }

               echo "<h1> Your ingame participant id was: " . $userParticipantId . "</h1>";

               //Figure out what champion the user was playing!
               $championId = $userMatch["participants"][$userParticipantId - 1]["championId"];
               $championName = getChampionName($championId);
               echo "<h1> You were playing " . $championName . "!</h1>";

               $matchWon = $userMatch["participants"][$userParticipantId - 1]["stats"]["winner"];
               if($matchWon)
                    $matchWins++;
          }
          $matchCount = $i;
          echo "<h1>Your winrate is " . ($matchWins/$matchCount)*100 . "%</h1><br>";
     }

     else{
          echo "<p>Try again but this time enter some usernames ;)</p>";
     }
?>