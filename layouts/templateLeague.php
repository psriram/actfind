<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Leagueup-Connecting people to leagues</title>
        <base href="<?php echo HTTPPATH; ?>/layouts/home/" />
        <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <!-- custom css -->
        <link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
        <!-- font awesome for icons -->
        <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet">
        <!-- flex slider css -->
        <link href="css/flexslider.css" rel="stylesheet" type="text/css" media="screen">
        <!-- animated css  -->
        <link href="css/animate.css" rel="stylesheet" type="text/css" media="screen">
        <!--owl carousel css-->
        <link href="css/owl.carousel.css" rel="stylesheet" type="text/css" media="screen">
        <link href="css/owl.theme.css" rel="stylesheet" type="text/css" media="screen">

  </head>
    <body>
          <div class="top-bar-wrap hidden-xs">
              <div class="container">
                  <div class="top-bar">
                      <div class="pull-left pull-left_color">
                          <button type="btnFindLeague" class="btn btn-theme-bg">Find a League</button>
                          <button type="btnRegisterLeague" class="btn btn-theme-bg">Register a League
                          </button>
                      </div>
                      <div class="pull-right pull-left_color">
                          <button type="btnSignUp" class="btn btn-theme-bg">Sign Up</button>
                      </div>
                      <!--
                      <div class="pull-right">
                          <ul class="list-inline social-1">
                              <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                              <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                              <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                              <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                              <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                          </ul>
                      </div>
                  </div>--><!--top-bar-->
                </div>
            </div><!--top bar wrap end-->
          <!--navigation -->
          <!-- Static navbar -->

            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!--<a class="navbar-brand" href="index.html">Sports Connect</a>-->
                </div><!--.navbar header-->


            </div><!--.container-->

     <!--  <section id="main-slider" style="height:400px;">
            <div class="container">

                <div class="row">
                    <div class="col-md-12">
                        <div class="main-slider">
                            <ul class="slides">
                                <li>
                                    <h2></h2>
                                    <p><a href="#" class="btn border-white">Sign me up</a></p>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>--><!--slider main parallax-->


        <div class="container">
            <?php echo $contentForTemplate; ?>

        </div>
      </div>



        <!--bootstrap js plugin-->
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!--easing plugin for smooth scroll-->
        <script src="js/jquery.easing.1.3.min.js" type="text/javascript"></script>
        <!--easing plugin for nice scroll scroll-->
        <script src="js/jquery.nicescroll.min.js" type="text/javascript"></script>
        <!--sticky header-->
        <script type="text/javascript" src="js/jquery.sticky.js"></script>
        <!--flex slider plugin-->
        <script src="js/jquery.flexslider-min.js" type="text/javascript"></script>
        <!--parallax background plugin-->
        <script src="js/jquery.stellar.min.js" type="text/javascript"></script>
        <!--very easy to use portfolio filter plugin -->
        <script src="js/jquery.mixitup.min.js" type="text/javascript"></script>
        <!--digit countdown plugin-->
        <script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
        <!--digit countdown plugin-->
        <script src="js/jquery.counterup.min.js" type="text/javascript"></script>
        <!--on scroll animation-->
        <script src="js/wow.min.js" type="text/javascript"></script>
        <!--owl carousel slider-->
        <script src="js/owl.carousel.min.js" type="text/javascript"></script>
        <!--customizable plugin edit according to your needs-->
        <script src="js/custom.js" type="text/javascript"></script>

    </body>
</html>
