<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Solo/Duo">
    <meta name="author" content="Cesar Diaz and Scott Chen">
    <link rel="icon" href="css/img/favicon.ico">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Fira+Sans">

    <title>Solo/Duo</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/starter-template.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body id="lol-background-image">

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
          <a class="navbar-brand" href="index.php">Solo / Duo</a>
          <a class="navbar-brand nav-bar-position" href="contact.php">Contact</a>
      </div>
    </nav>

    <div class="container">
      <div class="starter-template">
        <div class="card">
        <h1 id="title-font">Solo / Duo</h1>
        <p class="lead" id="title-description"> Enter your summoner names to calculate your ranked solo and duo win rates! </p>
        <form name="form" action="results.php" onsubmit="return validateForm()" role="form" method="post">
          <div class="form-group">
            <label class="form-text-size">Your Summoner Name:</label>
            <input id="user" type="text" class="form-control" name="user">
            <label class="form-text-size">Duo's Summoner Name:</label>
            <input type="text" class="form-control" name="duoPartner">
            <select id="region" name="region">
              <option value="na">North America</option>
              <option value="euw">EU West</option>
            </select>
            <button id="button-jquery" class="btn-primary rounded btn-lg">Submit</button>
          </div>
        </form>
      </div>
      </div>
    </div>

    <script src="/js/buttonJquery.js"></script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
