<?php
     include 'jsonHelper.php';
     
     $user = htmlspecialchars($_POST['user']);
     $duoPartner  = htmlspecialchars($_POST['duoPartner']);

     //Checks if you've entered a single username or two and gives the appropriate response
     if($user != ""){
          $user_summoner_info = getSummonerInfo($user);
          echo $user_summoner_info[$user]['id'] . "<br>";
          $userMatchIDUrl = "https://na.api.pvp.net/api/lol/na/v2.2/matchlist/by-summoner/" . $user_summoner_info[$user]['id'] . "?api_key=5416b2e6-d64c-4826-8b68-3cb6ee7489ff";
          $userMatchIDString = file_get_contents($userMatchIDUrl);
          $userMatchListJSON = json_decode($userMatchIDString, true);

          if($duoPartner != ""){
               $duoPartner_summoner_info = getSummonerInfo($duoPartner);
               echo $duoPartner_summoner_info[$duoPartner]['id'] . "<br>";
          }
          
          echo "Your very last ranked match: " . $userMatchListJSON["matches"][0]["timestamp"];
     }
?>