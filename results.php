<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="SoloOrDuo">
    <meta name="author" content="Cesar Diaz">
    <link rel="icon" href="../../favicon.ico">

    <title>SoloOrDuo</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/starter-template.css" rel="stylesheet">

    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
          <a class="navbar-brand" href="index.php">Solo Or Duo</a>
      </div>
    </nav>

    <div class="container">
      <h1>
        <?php
          $user = htmlspecialchars($_POST['user']);
          $userUrl = "https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/" 
              . $user . "?api_key=451d171b-aefb-4b11-ba80-212cbbcc9d79";
          $userJson = file_get_contents($userUrl);
          $user_summoner_info = json_decode($userJson, true);

          $duoPartner  = htmlspecialchars($_POST['duoPartner']);
          $duoPartnerUrl = "https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/" 
              . $duoPartner . "?api_key=451d171b-aefb-4b11-ba80-212cbbcc9d79";
          $duoPartnerJson = file_get_contents($duoPartnerUrl);
          $duoPartner_summoner_info = json_decode($duoPartnerJson, true);

          echo $user_summoner_info[$user]['id'] . "<br>" . $duoPartner_summoner_info[$duoPartner]['id'] . "<br>";

          // Temporary code, just gives you back the match id of your last ranked game
          $userMatchIDUrl = "https://na.api.pvp.net/api/lol/na/v2.2/matchlist/by-summoner/"
              . $user_summoner_info[$user]['id'] . "?api_key=5416b2e6-d64c-4826-8b68-3cb6ee7489ff";
          $userMatchIDString = file_get_contents($userMatchIDUrl);
          $userMatchListJSON = json_decode($userMatchIDString, true);
          echo "Your very last ranked match: " . $userMatchListJSON["matches"][0]["timestamp"];
        ?>
      </h1>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>