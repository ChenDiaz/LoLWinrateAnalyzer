<?php
  session_start();
?>

<?php
    include 'config.php';

    $apiKey = $_SESSION["apiKey"];

    function authenticateRegion($region) {
        return ($region == 'na');
    }

    function getSummonerId($user) {
        global $apiKey;

        $conn = new PDO("mysql:host=localhost;dbname=userIds","root","HV6FFuPZSl");
        $stmt = $conn->prepare("SELECT userId FROM userIds Where username=?");
        $stmt->bindValue(1, $user, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) != 0) {
          echo "<script>console.log(0);</script>";
          $userId = $result[0]['userId'];
        }
        else {
            echo "<script>console.log(1);</script>";
            $userTrimmed = rawurlencode($user);
            $userUrl = regionUrl . "/v1.4/summoner/by-name/" . $userTrimmed
                    . "?api_key=" . $apiKey;
            $urlHeader = get_headers($userUrl);

            //BandAid solution for every http request error
            if($urlHeader[0] != "HTTP/1.1 200 OK") {
                return 'N/A';
            }
            else {
                $userJson = file_get_contents($userUrl);
                $userData = json_decode($userJson, true);

                // The following three lines are added to revert the
                // summoner name back from html encoding in order for it to
                // work with the damn api
                $userTrimmed = urldecode($userTrimmed);
                $userTrimmed = strtolower($userTrimmed);
                $userTrimmed = preg_replace('/\s+/', '', $userTrimmed); //takes out whitespaces

                $userId = $userData[$userTrimmed]['id'];
                $insertUser = "INSERT INTO userIds VALUES ('$user', $userId)";
                $conn->exec($insertUser);
            }
        }

        $conn = null;
        return $userId;
    }

    function getMatchList($userId) {
        global $apiKey;
        $userMatchIdUrl = regionUrl . "/v2.2/matchlist/by-summoner/" . $userId
                . "?rankedQueues=RANKED_SOLO_5x5&beginIndex=0&endIndex=50&api_key=" . $apiKey;
        $userMatchIdJSON = file_get_contents($userMatchIdUrl);
        $userMatchList = json_decode($userMatchIdJSON, true);

        return $userMatchList;
    }

    function individualMatchData($numberOfMatches, $userMatchList, $userId, $duoId) {
        global $apiKey;
        $overallMatchDataArray = array();
        $numberOfSoloGames = 50;
        for ($i = 0; $i < $numberOfMatches; $i++) {
            // variables to be added to the associative array for each match
            $individualMatchArray = array();
            $playedSolo = true;

            $userMatchURL = regionUrl . "/v2.2/match/" . $userMatchList["matches"][$i]["matchId"]
                    . "?api_key=" . $apiKey;
            $userMatchJSON = file_get_contents($userMatchURL);
            $userMatch = json_decode($userMatchJSON, true);

            $userParticipantId = 0;

            // This loop figures out which games are played solo and which ones are played duo
            for ($j = 0; $j < 10; $j++) {
                $summonerId = $userMatch["participantIdentities"][$j]["player"]["summonerId"];
                if ($summonerId == $userId)
                {
                    // the user is one of summoners 1-10 –– the "participantId"
                    $userParticipantId = $userMatch["participantIdentities"][$j]["participantId"];
                }
                if ($summonerId == $duoId) {
                    $playedSolo = false;
                    $numberOfSoloGames--;
                }
            }

            $matchWon = $userMatch["participants"][$userParticipantId - 1]["stats"]["winner"];

            // Things in the associative array: champ played, match won, soloOrDuo, KDA, and match date
            $individualMatchArray["matchWon"] = $matchWon;
            $individualMatchArray["playedSolo"] = $playedSolo;
            $individualMatchArray["numberOfSoloGames"] = $numberOfSoloGames;

            // collect the info about each match into an array of associative arrays
            array_push($overallMatchDataArray, $individualMatchArray);
        }

        return $overallMatchDataArray;
    }

    function MatchesWon($arrayOfMatchData, $numberOfMatches, $playedSolo) {
        $gamesWon = 0;
        $gamesLost = 0;
        $winLossArray = array();
        for ($i = 0; $i < $numberOfMatches; $i++) {
            if ($arrayOfMatchData[$i]["playedSolo"] == $playedSolo) {
                if ($arrayOfMatchData[$i]["matchWon"] == true) {
                    $gamesWon++;
                }
                else {
                    $gamesLost++;
                }
            }
        }
        $winLossArray["gamesWon"] = $gamesWon;
        $winLossArray["gamesLost"] = $gamesLost;

        return $winLossArray;
    }

    function calculateWinRate($matchWins, $matchCount) {
        if ($matchCount == 0) {
            echo "<p id='no-duo-message'>No duo queue games with this summoner recently!</p>";
            return "N/A";
        }
        $winrate = ($matchWins / $matchCount) * 100;
        // only print out one decimal point
        $winrate = number_format($winrate, 1);
        return $winrate;
    }

    function winRateColor($winrate) {
        if ($winrate > 50.5)
            return "green";
        if ($winrate > 45)
            return "yellow";
        return "red";
    }