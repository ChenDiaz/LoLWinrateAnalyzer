
<?php
     /*
          **********************************************************************
          We need to handle various error codes in case Riot's api's goes down.
          **********************************************************************
     */
     include 'jsonHelper.php';
     
     //Gets data from index.php
     $userUntrimmed = htmlspecialchars($_POST['user']);
     // rawurlencode(string) converts spaces to %20
     $user = rawurlencode($userUntrimmed);
     $duoPartnerUntrimmed  = htmlspecialchars($_POST['duoPartner']);
     $duoPartner = rawurlencode($duoPartnerUntrimmed);

     //Nested ifs check if you've entered a single username or two and gives the appropriate response
     if ($user != "") {
          //Gets and prints user_id using jsonHelper
          $userId = getSummonerId($user);
          //echo "<h2 class='summoner-id' id='summoner-id-top-margin'>" . $user . " ID: " . $userId . "</h2><br>";

          //Same thing for duo partner
          $duoPartnerId = ($duoPartner != "") ? getSummonerId($duoPartner) : "";

          // card title
          echo "<div class='results-card card-margin'><h1 id='align-center'><b>(" . $userUntrimmed . ")</b></h1>";
          echo "<h3 id='ranked-match-background'>Recent Solo Matches</h3>";


          //Gets user's match list using jsonHelper
          $userMatchList = getMatchList($userId);

          $matchCount = 10;
          $arrayOfMatchData = individualMatchData($matchCount, $userMatchList, $userId, $duoPartnerId);
          $numberOfSoloGames = $arrayOfMatchData[$matchCount-1]["numberOfSoloGames"];
          
          $soloGamesWon = printSoloGamesWon($arrayOfMatchData, $matchCount);
          $soloWinRate = calculateWinrate($soloGamesWon, $numberOfSoloGames);

          echo "<h1>Solo winrate: <span id='yellow'>" . $soloWinRate . "</span></h1></div>";

          echo "<div class='results-card card-margin'>";

          if ($duoPartner != "")
               echo "<h1 id='align-center'><span id='light-title'>Duo with</span><b> (" . $duoPartnerUntrimmed . ")</h1></b>";
          else
               echo "<h1 id='align-center'><span id='light-title'>No duo partner</h1></b>";

          echo "<h3 id='ranked-match-background'>Recent Duo Matches</h3>";
          $duoGamesWon = printDuoGamesWon($arrayOfMatchData, $matchCount);
          $numberOfDuoGames = $matchCount - $numberOfSoloGames;
          $duoWinRate = calculateWinrate($duoGamesWon, $numberOfDuoGames);
          echo "<h1>Duo winrate: <span id='yellow'>" . $duoWinRate . "</span></h1></div>";
          echo "</div>";
     }

     // user neglected to enter any summoner name into the form
     else {
          echo "<p>Try again but this time enter some usernames ;)</p>";
     }
?>