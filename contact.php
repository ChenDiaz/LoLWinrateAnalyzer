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

  <body id="ezreal-background-image">

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
          <a class="navbar-brand" href="index.php">Solo / Duo</a>
          <a class="navbar-brand nav-bar-position" href="contact.php">Contact</a>
      </div>
    </nav>

    <div class="container">
        <div class="starter-template">
        <div class="card">
        <h1 id="title-font">Contact Us</h1>
        <div id="contact-margin">
        <?php
          $pictureFilePath = "css/img/Scott.png";
          $img = '<img src="' . $pictureFilePath . '" alt="Smiley face" height="150" width="150" class="profile-pic-rounded">';

          echo "<div class='person'><h4 id='match-font'>" . $img . "</h4>";
          echo "<div><p class='contact-name-font-size'>Scott Chen</p>";
          echo "<p class='contact-email-font-size'>scottchen625@gmail.com</p></div>";
          echo "</div>";

          $pictureFilePath = "css/img/Alex.png";
          $img = '<img src="' . $pictureFilePath . '" alt="Smiley face" height="150" width="150" class="profile-pic-rounded">';

          echo "<div class='person'><h4 id='match-font'>" . $img . "</h4>";
          echo "<div><p class='contact-name-font-size'>Alex Diaz</p></div>";
          echo "<div><p class='contact-email-font-size'>calexdiaz143@gmail.com</p></div></div>";
        ?>
        </div>
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