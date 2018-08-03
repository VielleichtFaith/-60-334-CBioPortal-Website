  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Compiled study data from CBioPortal</title>

    <!--Bootstrap core CSS-->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../js/html5shiv.min.js"></script>
      <script src="../js/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
    <link href="../css/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/contact-input-style.css">
    <link rel="stylesheet" href="../css/hover-effect.css">
    <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css" />

  </head>
<!-- NAVBAR
================================================== -->
  <body>
   


<nav class="navbar navbar-default top-bar affix" data-spy="affix" data-offset-top="250" >
    <div class="container" >
        <!- Brand and toggle get grouped for better mobile display ->
        <div class="navbar-header page-scroll">
            <button data-target="#bs-example-navbar-collapse-1" data-toggle="collapse" class="navbar-toggle" type="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="index.html#home" class="navbar-brand">Home</a>
        </div>
        <!- Collect the nav links, forms, and other content for toggling ->
        <div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
		<li><a href="index.html#analytics">Analytics</a></li>
                <li><a href="index.html#about">About</a></li>
                <li><a href="index.html#contact">Contact</a></li>
                <li><a href="redirect.php">Profile</a></li>                
            </ul>
        </div>
        <!- /.navbar-collapse ->
    </div>
    <!- /.container-fluid ->
</nav>
<!--================================================== -->

 <section class="banner-sec" id="home">
 <div class="container">
 <div class="jumbotron">
 <h1>Welcome, <?php echo $_POST["username"]; ?></h1>
 <form action="logout.php" method="post"><input type="submit" value="Log Out" class="btn btn-search"></form> 

  </div>
  </div>
  </div>
  </section>
<!--================================================== -->
<footer>
<div class="container">
<div class="row">
<p class="text-center">Shared by <i class="fa fa-love"></i><a href="www.uwindsor.ca">University of Windsor</a>
</p>
</div>
</div>
</footer>
    

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../js/ie10-viewport-bug-workaround.js"></script>
    <script src="../js/oppear_1.1.2.min.js"></script>    
<!--================================================== -->
    <script>
    $('a[href^="#"]').on('click', function(event) {

    var target = $( $(this).attr('href') );

    if( target.length ) {
        event.preventDefault();
        $('html, body').animate({
            scrollTop: target.offset().top
        }, 1000);
    }

});

    </script>
  </body>
</html>
