<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
          html, body, #map-canvas {
            height: 100%;
            margin: 0px;
            padding: 0px
          }
        </style>
        <title>Leagueup-Connecting people to leagues</title>
        <base href="<?php echo HTTPPATH; ?>/layouts/home/" />
        <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
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
        <link href="<?php echo HTTPPATH; ?>/scripts/autocomplete/jquery.autocomplete.css" rel="stylesheet" type="text/css">
        <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
         <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script>
    // This example displays an address form, using the autocomplete feature
    // of the Google Places API to help users fill in the information.
    $( document ).ready(function() {
        initialize();
    });
    var placeSearch, autocomplete;
    var componentForm = {
      street_number: 'short_name',
      route: 'long_name',
      locality: 'long_name',
      administrative_area_level_1: 'short_name',
      country: 'long_name',
      postal_code: 'short_name'
    };

    function initialize() {
      // Create the autocomplete object, restricting the search
      // to geographical location types.
      autocomplete = new google.maps.places.Autocomplete(
          /** @type {HTMLInputElement} */(document.getElementById('autocomplete')),
          { types: ['geocode'] });
      // When the user selects an address from the dropdown,
      // populate the address fields in the form.
      google.maps.event.addListener(autocomplete, 'place_changed', function() {
        fillInAddress();
      });
    }

    // [START region_fillform]
    function fillInAddress() {
      // Get the place details from the autocomplete object.
      var place = autocomplete.getPlace();
      document.getElementById("hdnLat").value = place.geometry.location.lat();
      document.getElementById("hdnLong").value = place.geometry.location.lng();
      //console.log(place);
      //alert(place.geometry.location.lat());
      //alert(place.geometry.location.lng());
      /*
      for (var component in componentForm) {
        document.getElementById(component).value = '';
        document.getElementById(component).disabled = false;
      }

      // Get each component of the address from the place details
      // and fill the corresponding field on the form.
      for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
          var val = place.address_components[i][componentForm[addressType]];
          document.getElementById(addressType).value = val;
        }
      }*/
    }
    // [END region_fillform]

    // [START region_geolocation]
    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          var geolocation = new google.maps.LatLng(
              position.coords.latitude, position.coords.longitude);
          autocomplete.setBounds(new google.maps.LatLngBounds(geolocation,
              geolocation));
        });
      }
    }
    // [END region_geolocation]

        </script>

        <style>
          #locationField, #controls {
            position: relative;
            width: 480px;
          }
          #autocomplete {
            position: absolute;
            top: 0px;
            left: 0px;
            width: 40%;
          }
          .label {
            text-align: right;
            font-weight: bold;
            width: 100px;
            color: #303030;
          }
          #address {
            border: 1px solid #000090;
            background-color: #f0f0ff;
            width: 480px;
            padding-right: 2px;
          }
          #address td {
            font-size: 10pt;
          }
          .field {
            width: 99%;
          }
          .slimField {
            width: 80px;
          }
          .wideField {
            width: 200px;
          }
          #locationField {
            height: 20px;
            margin-bottom: 2px;
          }
        </style>

    </head>
    <body>
        <div class="top-bar-wrap hidden-xs">
            <div class="container">
                <div class="top-bar">
                    <div class="pull-left pull-left_color">
                        <button id="btnFindLeague" class="btn btn-theme-bg">Find a League</button>
                        <button id="btnRegisterLeague" class="btn btn-theme-bg">Register a League
                        </button>
                    </div>
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

         <div class="divide40"></div>
        <form id="searchForm" action="/activity/searchresults" method="post">
        <div class="container">
        <div class="row">
            <div class="col-md-12">
            <div class="purchase-section ">
                <div class="row">
                    <div class="col-md-4">
                            <div class="dropdown">
                                  <input
                                    id="mainKeywords"
                                    class="dropdown-toggle"
                                    data-toggle="dropdown"
                                    type="text"
                                    name="keywords"
                                    size="50"
                                    maxlength="100"
                                    value=""
                                    placeholder="All Activities"
                                    />

                                  <ul class="dropdown-menu" id="simple-criteria" role="menu" aria-labelledby="dropdownMenu1">
                                      <li role="presentation">
                                         <a role="menuitem" tabindex="-1" href="javascript:;" data-key="soccer" data-name="soccer">Soccer</a>
                                      </li>
                                      <li role="presentation">
                                         <a role="menuitem" tabindex="-1" href="javascript:;" data-key="lacrosse" data-name="lacrosse">Lacrosse</a>
                                      </li>
                                      <li role="presentation">
                                         <a role="menuitem" tabindex="-1" href="javascript:;" data-key="karate" data-name="karate">
                                           Karate
                                         </a>
                                      </li>
                                      <li role="presentation" class="divider"></li>
                                      <li role="presentation">
                                         <a role="menuitem" tabindex="-1" href="javascript:;" data-key="baseball" data-name="baseball">Baseball</a>
                                      </li>
                                   </ul>
                                </div>
                       </div>
                      <div class="col-md-1">
                                within
                     </div>
                       <div class="col-md-1">

                            <div class="dropdown">

                                <a href="javascript:;" id="lnkradius"class="dropdown-toggle"  data-toggle="dropdown">5</a> miles
                                <ul class="dropdown-menu" id="simple-radius">
                                    <li><a href="javascript:;" data-value="2" data-copy="2">
                                    2
                                    </a></li>
                                    <li><a href="javascript:;" data-value="10" data-copy="10">
                                    10
                                </a></li>
                                </ul>
                                 <input type="hidden" id="hdnRadius" name="hdnRadius" value="5"/>
                            </div>

                     </div>
                       <div class="col-md-1">
                               of
                     </div>
                        <div class="col-md-3">
                             <div id="locationField">
                              <input id="autocomplete" placeholder="Enter your address"
                                     onFocus="geolocate()" type="text"></input>
                                     <input type="hidden" id="hdnLat" name="hdnLat"/>
                               <input type="hidden" id="hdnLong" name="hdnLong"/>
                            </div>



                                <!--<div id="the-basics">
                                            <input class="typeahead" type="text" placeholder="Where">
                                </div>-->

                       </div>
                       <div class="col-md-1">
                            <input type="submit" name="go" id="go" value="Go" /><br />
                       </div>

                </div>
            </div>
          </div>
        </div>

        </div><!--purchase section-->
       </form>
       <div class="divide80"></div>

        <div class="container">
            <?php echo $contentForTemplate; ?>

        </div>
      </div>
      </div>
<footer id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 margin30">
                        <div class="footer-col">
                            <h3 class="heading">About us</h3>
                            <p>
                                Duis nisl est, porta eu augue et, tempor congue mauris. Praesent a ligula in urna consectetur rhoncus.
                            </p>
                            <ul class="address-info list-unstyled">
                                <li><i class="fa fa-home"></i> Vaishali nagar, Jaipur, 302012</li>
                                <li><i class="fa fa-phone"></i> +91 123456789</li>
                                <li><i class="fa fa-envelope"></i> <a href="#">support@designmylife.com</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 margin30">
                        <div class="footer-col">
                            <h3 class="heading">Recent Post</h3>
                            <ul class="list-unstyled popular-post">
                                <li>
                                    <div class="popular-img">
                                        <a href="#"> <img src="img/work-6.png" class="img-responsive" alt=""></a>
                                    </div>
                                    <div class="popular-desc">
                                        <h5> <a href="#">blog post image</a></h5>
                                        <h6>31st july 2014</h6>
                                    </div>
                                </li>
                                <li>
                                    <div class="popular-img">
                                        <a href="#"> <img src="img/work-2.png" class="img-responsive" alt=""></a>
                                    </div>
                                    <div class="popular-desc">
                                        <h5> <a href="#">blog post image</a></h5>
                                        <h6>31st july 2014</h6>
                                    </div>
                                </li>
                                <li>
                                    <div class="popular-img">
                                        <a href="#"> <img src="img/work-5.png" class="img-responsive" alt=""></a>
                                    </div>
                                    <div class="popular-desc">
                                        <h5> <a href="#">blog post image</a></h5>
                                        <h6>31st july 2014</h6>
                                    </div>
                                </li>
                            </ul><!--latest post-->
                        </div>
                    </div><!--footer col-->
                    <div class="col-md-3 margin30">
                        <div class="footer-col">
                            <h3 class="heading">Elsewhere</h3>
                            <ul class="list-inline social-1">
                                <li><a href="#"><i class="fa fa-facebook" data-toggle="tooltip" title="" data-original-title="Facebook" data-placement="top"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter" data-toggle="tooltip" title="" data-original-title="Twitter" data-placement="top"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus" data-toggle="tooltip" title="" data-original-title="Google pluse" data-placement="top"></i></a></li>
                                <li><a href="#"><i class="fa fa-pinterest" data-toggle="tooltip" title="" data-original-title="Pinterest" data-placement="top"></i></a></li>
                                <li><a href="#"><i class="fa fa-dribbble" data-toggle="tooltip" title="" data-original-title="Dribbble" data-placement="top"></i></a></li>
                            </ul>
                        </div>
                        <div class="divide30"></div>
                        <div class="footer-col">
                            <h3 class="heading">Newsletter</h3>
                            <p>
                                Duis nisl est, porta eu augue et, tempor congue mauris.
                            </p>
                            <form class="newsletter-form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <label class="sr-only" for="subscribe-email">Email address</label>
                                            <input type="email" class="form-control" id="subscribe-email" placeholder="Enter your email">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-theme-bg btn-lg">OK</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!--footer col-->
                    <div class="col-md-3 margin30">
                        <div class="footer-col">
                            <h3 class="heading">Recent Work</h3>
                            <div class=" footer-work">
                                <a href="#">
                                    <img src="img/work-1.png" class="img-responsive" alt="">
                                </a>
                                <a href="#">
                                    <img src="img/work-2.png" class="img-responsive" alt="">
                                </a>
                                <a href="#">
                                    <img src="img/work-10.jpg" class="img-responsive" alt="">
                                </a>
                                <a href="#">
                                    <img src="img/work-4.jpg" class="img-responsive" alt="">
                                </a>
                                <a href="#">
                                    <img src="img/work-5.png" class="img-responsive" alt="">
                                </a>
                                <a href="#">
                                    <img src="img/work-6.png" class="img-responsive" alt="">
                                </a>
                                <a href="#">
                                    <img src="img/work-7.png" class="img-responsive" alt="">
                                </a>
                                <a href="#">
                                    <img src="img/work-8.png" class="img-responsive" alt="">
                                </a>
                                <a href="#">
                                    <img src="img/work-9.png" class="img-responsive" alt="">
                                </a>
                            </div>
                        </div><!--footer col-->
                    </div>
                </div><!--row-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="footer-btm">
                            <span>&copy; Copyright 2014. Theme by Design_mylife</span>
                        </div>
                    </div>
                </div>
            </div>
        </footer><!--footer end-->
        <!--scripts and plugins -->
        <!--must need plugin jquery-->

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
