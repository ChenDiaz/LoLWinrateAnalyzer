
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
          echo "Your user ID is: " . $userId . "<br>";

          //Same thing for duo partner
          if ($duoPartner != "") {
               $duoPartnerId = getSummonerId($duoPartner);
               echo "Your duo's ID is: " . $duoPartnerId . "<br><br>";
          }

          echo "***Your ranked stats***"; // Temporary placeholder, will get rid of this line soon

          //Gets user's match list using jsonHelper
          $userMatchList = getMatchList($userId);

          $matchCount = 10;
          $matchWins = matchesWon($matchCount, $userMatchList, $userId);
          
          echo "<h1>Your winrate is " . ($matchWins / $matchCount) * 100 . "%</h1><br>";
     }

     else {
          echo "<p>Try again but this time enter some usernames ;)</p>";
     }
?>