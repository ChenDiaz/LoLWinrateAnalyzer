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
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/starter-template.css" rel="stylesheet">

    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body id="lol-background-image">

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
          <a class="navbar-brand" href="index.php">Solo Or Duo</a>
      </div>
    </nav>

    <div class="container">
      <div class="starter-template">
        <div class="card">
        <h1 id="title-font">Solo Or Duo</h1>
        <p class="lead"> Enter your summoner names to calculate your solo and duo win rates! </p>
        <form action="results.php" role="form" method="post">
          <div class="form-group">
            <label>Username:</label>
            <input type="text" class="form-control" name="user">
            <label>Duo's Username:</label>
            <input type="text" class="form-control" name="duoPartner">
            <br>
            <button class="btn-primary button-rounded" id='button-size'>Submit</button>
          </div>
        </form>
      </div>
      </div>
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
