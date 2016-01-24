<?php
     /*
          **********************************************************************
          Take the following two lines out when we push this to production!!!
          **********************************************************************
     */
     ini_set('display_errors', 'On');
     error_reporting(E_ALL | E_STRICT);



     include 'jsonHelper.php';
     
     //Gets data from index.php
     $userUntrimmed = htmlspecialchars($_POST['user']);
     $user = rawurlencode($userUntrimmed);

     $duoPartnerUntrimmed  = htmlspecialchars($_POST['duoPartner']);
     $duoPartner = rawurlencode($duoPartnerUntrimmed);

     $userId = getSummonerId($user);

     $duoPartnerId = ($duoPartner != "") ? getSummonerId($duoPartner) : "";

     //Processing result
     if($userId != 'N/A' && $duoPartnerId != 'N/A')
     {
          // card title
          echo "<div class='results-card card-margin'><h1 class='align-center'><b><span id='light-title'>Solo</span> " . $userUntrimmed . "</b></h1>";

          //Gets user's match list using jsonHelper
          $userMatchList = getMatchList($userId);

          $matchCount = 10;
          $arrayOfMatchData = individualMatchData($matchCount, $userMatchList, $userId, $duoPartnerId);
          $numberOfSoloGames = $arrayOfMatchData[$matchCount-1]["numberOfSoloGames"];
          
          $soloWinLostArray = MatchesWon($arrayOfMatchData, $matchCount, true);
          $soloWins = $soloWinLostArray["gamesWon"];
          $soloLosses = $soloWinLostArray["gamesLost"];
          $soloWinRate = calculateWinrate($soloWins, $numberOfSoloGames);
          $winRateColor = winRateColor($soloWinRate);

          echo "<h2>Wins: <span class='won-message'>" . $soloWins . "</span> Losses: <span class='lost-message'>"
                          . $soloLosses . "</span></h2>";
          echo "<h1>Solo winrate: <span id='" . $winRateColor . "'>" . $soloWinRate . "%</span></h1></div>";

          echo "<div class='results-card card-margin'>";

          if ($duoPartner != "")
               echo "<h1 id='align-center'><span id='light-title'>Duo with</span><b> " . $duoPartnerUntrimmed . "</h1></b>";
          else
               echo "<h1 class='align-center'><span id='light-title'>No duo partner specified</h1></b>";


          $duoWinLostArray = MatchesWon($arrayOfMatchData, $matchCount, false);
          $numberOfDuoGames = $matchCount - $numberOfSoloGames;
          $duoWins = $duoWinLostArray["gamesWon"];
          $duoLosses = $duoWinLostArray["gamesLost"];
          $duoWinRate = calculateWinrate($duoWins, $numberOfDuoGames);
          $winRateColor = winRateColor($duoWinRate);

          echo "<h2>Wins: <span class='won-message'>" . $duoWins . "</span> Losses: <span class='lost-message'>"
                          . $duoLosses . "</span></h2>";
          echo "<h1>Duo winrate: <span id='" . $winRateColor . "'>" . $duoWinRate . "%</span></h1></div>";
          echo "</div>";
     }
     else
     {
          $pictureFilePath = "css/img/ErrorAmumu.png";
          $img = '<img id="errorAmumu" src="' . $pictureFilePath . '">';

          echo "<div class='container'><div class='starter-template'><div class='card'>";
          echo "<h2 class='align-center'>Uh Oh</h2>";
          echo "<div>" . $img . "</div>";
          echo "<h3>There was an error in your submission. Try again.<h3>";
          echo "</div></div></div>";
     }