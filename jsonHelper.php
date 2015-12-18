<?php
	//General function for getting and decoding user JSON data
	function getSummonerId($user) {
		$userUrl = "https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/" . $user 
				. "?api_key=5416b2e6-d64c-4826-8b68-3cb6ee7489ff";
        $userJson = file_get_contents($userUrl);
        $userData = json_decode($userJson, true);

        // The following two lines are added to revert the
        // summoner name back from html encoding in order for it to
        // work with the damn api
        $user = rawurldecode($user);
        $user = preg_replace('/\s+/', '', $user);
        $user = strtolower($user);

        $userId = $userData[$user]['id'];

        return $userId;
	}

	function getMatchList($userId) {
		$userMatchIdUrl = "https://na.api.pvp.net/api/lol/na/v2.2/matchlist/by-summoner/" . $userId 
				. "?rankedQueues=RANKED_SOLO_5x5&beginIndex=0&endIndex=12&api_key=5416b2e6-d64c-4826-8b68-3cb6ee7489ff";
        $userMatchIdJSON = file_get_contents($userMatchIdUrl);
        $userMatchList = json_decode($userMatchIdJSON, true);

        return $userMatchList;
	}

	function getChampionName($championId) {
		$championIdURL = "https://global.api.pvp.net/api/lol/static-data/na/v1.2/champion/" . $championId 
				. "?api_key=5416b2e6-d64c-4826-8b68-3cb6ee7489ff";
		$championIdJSON = file_get_contents($championIdURL);
		$championIdData = json_decode($championIdJSON);
		$championName = $championIdData->name;

		return $championName;
	}

/*
    NEED to split matchesWon into THREE FUNCTIONS

    DONEZO (one): return "champion played"/"match-won" as an array of associative arrays
    DONZO BABY (two): print out solo matches won (for card 1)
    DONEZO BABY (three): print out duo matches won (for card 2)
*/


	function individualMatchData($numberOfMatches, $userMatchList, $userId, $duoId) {
        $overallMatchDataArray = array();
        $numberOfSoloGames = 10;
        for ($i = 0; $i < $numberOfMatches; $i++) {
            // variables to be added to the associative array for each match
            $individualMatchArray = array();
            $playedSolo = true;

            $userMatchURL = "https://na.api.pvp.net/api/lol/na/v2.2/match/" . $userMatchList["matches"][$i]["matchId"] 
            		. "?api_key=451d171b-aefb-4b11-ba80-212cbbcc9d79";
            $userMatchJSON = file_get_contents($userMatchURL);
            $userMatch = json_decode($userMatchJSON, true);

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

            //Figure out what champion the user was playing!
            $championId = $userMatch["participants"][$userParticipantId - 1]["championId"];
            $championName = getChampionName($championId);

            $matchWon = $userMatch["participants"][$userParticipantId - 1]["stats"]["winner"];

            // Need 3 things in the associative array: champ played, match won, soloOrDuo
            $individualMatchArray["champPlayed"] = $championName;
            $individualMatchArray["matchWon"] = $matchWon;
            $individualMatchArray["playedSolo"] = $playedSolo;
            $individualMatchArray["numberOfSoloGames"] = $numberOfSoloGames;

            array_push($overallMatchDataArray, $individualMatchArray);
        }
        return $overallMatchDataArray;
	}

    function printSoloGamesWon($arrayOfMatchData, $numberOfMatches) {
        $gamesWon = 0;
        for ($i = 0; $i < $numberOfMatches; $i++) {
            if ($arrayOfMatchData[$i]["playedSolo"] == true) {
                $championName = $arrayOfMatchData[$i]["champPlayed"];
                if ($arrayOfMatchData[$i]["matchWon"] == true) {
                    $gamesWon++;
                    echo "<h4>Game " . ($i + 1) . ": --- " . $championName . " [K/D/A] <span class='won-message'>(won)</span> </h4>";
                }
                else {
                    echo "<h4>Game " . ($i + 1) . ": --- " . $championName ." [K/D/A] <span class='lost-message'>(lost)<span> </h4>";
                }
            }
        }
        return $gamesWon;
    }

    function printDuoGamesWon($arrayOfMatchData, $numberOfMatches) {
        $gamesWon = 0;
        for ($i = 0; $i < $numberOfMatches; $i++) {
            if ($arrayOfMatchData[$i]["playedSolo"] == false) {
                $championName = $arrayOfMatchData[$i]["champPlayed"];
                if ($arrayOfMatchData[$i]["matchWon"] == true) {
                    $gamesWon++;
                    echo "<h4>Game " . ($i + 1) . ": --- " . $championName . " [K/D/A] <span class='won-message'>(won)</span> </h4>";
                }
                else {
                    echo "<h4>Game " . ($i + 1) . ": --- " . $championName ." [K/D/A] <span class='lost-message'>(lost)<span> </h4>";
                }
            }
        }
        return $gamesWon;
    }

    function calculateWinRate($matchWins, $matchCount) {
        if ($matchCount == 0) {
            echo "<p id='no-duo-message'>No duo queue games with this summoner recently!</p>";
            return "N/A";
        }
        $winrate = ($matchWins / $matchCount) * 100;
        // only print out one decimal point
        $winrate = number_format($winrate, 1);
        return $winrate . "%";
    }
?>