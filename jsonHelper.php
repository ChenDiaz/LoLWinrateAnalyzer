<?php
	//General function for getting and decoding user JSON data
	function getSummonerId($user){
		$userUrl = "https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/" . $user . "?api_key=451d171b-aefb-4b11-ba80-212cbbcc9d79";
        $userJson = file_get_contents($userUrl);
        $userData = json_decode($userJson, true);
        $userId = $userData[$user]['id'];

        return $userId;
	}

	function getMatchList($userId){
		$userMatchIdUrl = "https://na.api.pvp.net/api/lol/na/v2.2/matchlist/by-summoner/" . $userId . "?api_key=5416b2e6-d64c-4826-8b68-3cb6ee7489ff";
        $userMatchIdJSON = file_get_contents($userMatchIdUrl);
        $userMatchList = json_decode($userMatchIdJSON, true);

        return $userMatchList;
	}

	function getChampionName($championId){
		$championIdURL = "https://global.api.pvp.net/api/lol/static-data/na/v1.2/champion/" . $championId . "?api_key=5416b2e6-d64c-4826-8b68-3cb6ee7489ff";
		$championIdJSON = file_get_contents($championIdURL);
		$championIdData = json_decode($championIdJSON);
		$championName = $championIdData->name;

		return $championName;
	}
?>