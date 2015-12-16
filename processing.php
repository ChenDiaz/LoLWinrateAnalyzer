
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
     if ($user != "") {
          //Gets and prints user_id using jsonHelper
          $userId = getSummonerId($user);
          echo "<h2 class='summoner-id' id='summoner-id-top-margin'>" . $user . " ID: " . $userId . "</h2><br>";

          //Same thing for duo partner
          if ($duoPartner != "") {
               $duoPartnerId = getSummonerId($duoPartner);
               echo "<h2 class='summoner-id'>" . $duoPartner . " ID: " . $duoPartnerId . "</h2><br><br>";
          }

          // Temporary placeholder, will get rid of this line soon
          echo "<div class=\"results-card\"><h1 id='align-center'>(" . $user . ")</h1>";
          echo "<h2>* Recent Ranked Matches *</h2>";

          //Gets user's match list using jsonHelper
          $userMatchList = getMatchList($userId);

          $matchCount = 10;
          $matchWins = matchesWon($matchCount, $userMatchList, $userId);
          $winrate = ($matchWins / $matchCount) * 100;
          // only print out one decimal point
          $winrate = number_format($winrate, 1);
          
          echo "<h1>Your solo winrate: <span id='yellow'>" . $winrate . "%</span></h1></div><br>";
     }

     else {
          echo "<p>Try again but this time enter some usernames ;)</p>";
     }
?>