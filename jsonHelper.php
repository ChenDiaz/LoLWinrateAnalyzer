<?php
	//General function for getting and decoding user JSON data
	function getSummonerId($user) {
		$userUrl = "https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/" . $user . "?api_key=5416b2e6-d64c-4826-8b68-3cb6ee7489ff";
        $userJson = file_get_contents($userUrl);
        $userData = json_decode($userJson, true);
        $userId = $userData[$user]['id'];

        return $userId;
	}

	function getMatchList($userId) {
		$userMatchIdUrl = "https://na.api.pvp.net/api/lol/na/v2.2/matchlist/by-summoner/" . $userId . "?rankedQueues=RANKED_SOLO_5x5&beginIndex=0&endIndex=12&api_key=5416b2e6-d64c-4826-8b68-3cb6ee7489ff";
        $userMatchIdJSON = file_get_contents($userMatchIdUrl);
        $userMatchList = json_decode($userMatchIdJSON, true);

        return $userMatchList;
	}

	function getChampionName($championId) {
		$championIdURL = "https://global.api.pvp.net/api/lol/static-data/na/v1.2/champion/" . $championId . "?api_key=5416b2e6-d64c-4826-8b68-3cb6ee7489ff";
		$championIdJSON = file_get_contents($championIdURL);
		$championIdData = json_decode($championIdJSON);
		$championName = $championIdData->name;

		return $championName;
	}

	function matchesWon($numberOfMatches, $userMatchList, $userId) {
		$matchWins = 0;
        for ($i = 0; $i < $numberOfMatches; $i++) {
            $userMatchURL = "https://na.api.pvp.net/api/lol/na/v2.2/match/" . $userMatchList["matches"][$i]["matchId"] . "?api_key=451d171b-aefb-4b11-ba80-212cbbcc9d79";
            $userMatchJSON = file_get_contents($userMatchURL);
            $userMatch = json_decode($userMatchJSON, true);

            for ($j = 0; $j < 10; $j++) {
                if ($userMatch["participantIdentities"][$j]["player"]["summonerId"] == $userId)
                {
                     // the user is one of summoners 1-10
                     $userParticipantId = $userMatch["participantIdentities"][$j]["participantId"];
                }
            }

            //Figure out what champion the user was playing!
            $championId = $userMatch["participants"][$userParticipantId - 1]["championId"];
            $championName = getChampionName($championId);
            echo "<h3>Game " . ($i + 1) . ": --- Champion played: " . $championName . "</h3>";

            $matchWon = $userMatch["participants"][$userParticipantId - 1]["stats"]["winner"];
            if ($matchWon)
                $matchWins++;
        }
        return $matchWins;
	}
?>