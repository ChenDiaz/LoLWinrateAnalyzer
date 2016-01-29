<?php
    
    function authenticateRegion($region) {
        return ($region == 'na');
    }

    function getSummonerId($user) {

        $conn = new PDO("mysql:host=" . hostName .";dbname=" . dbName, serverUser, serverPassword);
        $userQuery = "SELECT userId FROM userIds WHERE username = '$user'";
        $userSearch = $conn->query($userQuery);
        if ($userSearch->rowCount() > 0){
            echo "<script>console.log(0);</script>";
            $userId = $userSearch->fetch()[0];
        }
        else {
            echo "<script>console.log(1);</script>";
            $userTrimmed = rawurlencode($user);
            $userUrl = regionUrl . "/v1.4/summoner/by-name/" . $userTrimmed 
                    . "?api_key=" . apiKey;
            $urlHeader = get_headers($userUrl);

            //BandAid solution for every http request error
            if($urlHeader[0] != "HTTP/1.1 200 OK"){
                return 'N/A';
            }
            else {
                $userJson = file_get_contents($userUrl);
                $userData = json_decode($userJson, true);

                // The following three lines are added to revert the
                // summoner name back from html encoding in order for it to
                // work with the damn api
                $userTrimmed = preg_replace('/\s+/', '', $userTrimmed);
                $userTrimmed = strtolower($userTrimmed);

                $userId = $userData[$userTrimmed]['id'];
                $insertUser = "INSERT INTO userIds VALUES ('$user', $userId)";
                $conn->exec($insertUser);
            }
        }

        $conn = null;
        return $userId;
    }

    function getMatchList($userId) {    
        $userMatchIdUrl = regionUrl . "/v2.2/matchlist/by-summoner/" . $userId 
                . "?rankedQueues=RANKED_SOLO_5x5&beginIndex=0&endIndex=10&api_key=" . apiKey;
        $userMatchIdJSON = file_get_contents($userMatchIdUrl);
        $userMatchList = json_decode($userMatchIdJSON, true);

        return $userMatchList;
    }

    function individualMatchData($numberOfMatches, $userMatchList, $userId, $duoId) {
        $overallMatchDataArray = array();
        $numberOfSoloGames = 10;
        for ($i = 0; $i < $numberOfMatches; $i++) {
            // variables to be added to the associative array for each match
            $individualMatchArray = array();
            $playedSolo = true;

            $userMatchURL = regionUrl . "/v2.2/match/" . $userMatchList["matches"][$i]["matchId"] 
                    . "?api_key=" . apiKey;
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