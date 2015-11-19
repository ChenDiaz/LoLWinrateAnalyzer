<?php
	//General function for getting and decoding user JSON data
	function getSummonerInfo($user){
		$userUrl = "https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/" . $user . "?api_key=451d171b-aefb-4b11-ba80-212cbbcc9d79";
        $userJson = file_get_contents($userUrl);
        $userData = json_decode($userJson, true);
        return $userData;
	}
?>