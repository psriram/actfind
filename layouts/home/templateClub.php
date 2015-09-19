<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title></title>
        <base href="<?php echo HTTPPATH; ?>/layouts/home/" />
      <?php
        $file = SITEDIR.'/includes/club_header.php';

        if (file_exists($file)) {
          include_once($file);
        }
      ?>
<script type="text/javascript">
 $( document ).ready(function() {

    $('#btnLogOut').on('click', function(){
            window.location.href="/actfind/prototype/users/logout";
    });

 });
</script>
<script src="js/club.js" type="text/javascript"></script>

  </head>
    <body >
          <div class="top-bar-wrap hidden-xs">
              <div class="container">
                  <div class="top-bar">
                      <?php if (isset($_SESSION['user']['id'])) { ?>
                        <div class="pull-right">

                            <img src="<?php echo $_SESSION['user']['picture']; ?>" class="img-circle" alt="<?php echo $_SESSION['user']['name']; ?>"/>
                            <span class="btn btn-theme-bg"><?php echo $_SESSION['user']['name']; ?></span>

                            <button id="btnLogOut" class="btn btn-theme-bg">Log Out</button>
                        </div>
                      <?php } else { ?>
                        <div class="pull-right pull-left_color">
                            <button id="btnSignUp" class="btn btn-theme-bg">Sign Up</button>
                        </div>
                        <div class="pull-right pull-left_color">
                            <button id="btnSignIn" class="btn btn-theme-bg">Log In</button>
                        </div>
                      <?php } ?>
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



      </div>

      <div class="container">
            <?php echo $contentForTemplate; ?>

        </div>



    </body>
</html>
