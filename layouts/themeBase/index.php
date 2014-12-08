<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title><?php echo $pageTitle; ?></title>
    <base href="<?php echo HTTPPATH; ?>/layouts/themeBase/" />
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="<?php echo HTTPPATH; ?>/styles/site.css" rel="stylesheet">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link href="css/styles.css" rel="stylesheet">
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo HTTPPATH; ?>/scripts/jquery.number.js"></script>
<script src="<?php echo HTTPPATH; ?>/scripts/jquery.cookie.js"></script>

<script type="text/javascript" src="<?php echo HTTPPATH.'/scripts/map.js'; ?>"></script>
<script type="text/javascript" src="https://www.google.com/jsapi?key=ABQIAAAALUsWUxJrv3zXUNCu0Kas1RQFv3AXA4OcITNh-zHKPaxsGpzj0xQrVCwfLY_kBbxK-4-gSU4j3c7huQ"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

	</head>
	<body>
<!-- begin template -->
<?php include(SITEDIR.'/includes/menu.php'); ?>
<div id="mapCanvas"></div>
<div class="container-fluid" id="main">
  <div class="row">
    <div class="col-xs-4" id="leftsidebar"><!--map-canvas will be postioned here--></div>
    <div class="col-xs-6" id="middle">
    <?php echo $contentForTemplate; ?>
    </div>
    <div class="col-xs-2" id="right">
      <br />
      <div class="panel panel-primary">
        <div class="panel-heading">Search City</div>
        <div class="panel-body">
          <?php include(SITEDIR.'/locations/searchcity.php'); ?>
        </div>
      </div>
      <?php if (!empty($pageDynamicNavigationItem)) { ?>
      <div class="panel panel-primary">
        <div class="panel-heading">Information</div>
        <div class="panel-body">
          <?php echo $pageDynamicNavigationItem; ?>
        </div>
      </div>
      <?php } ?>
      
      <?php if (!empty($pageDynamicNearby)) { ?>
      <div class="panel panel-primary">
        <div class="panel-heading">Nearby Cities</div>
        <div class="panel-body">
          <?php echo $pageDynamicNearby; ?>
        </div>
      </div>
      <?php } else { ?>
      
        <div id="homepagenearby" style="display:none;" class="panel panel-primary">
          <div class="panel-heading">Nearby Cities</div>
          <div class="panel-body" id="homepagenearbycontent">
            
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
<!-- end template -->

	<!-- script references <script src="http://maps.googleapis.com/maps/api/js?sensor=false&extension=.js&output=embed"></script>-->
<script src="js/bootstrap.min.js"></script>
<!-- ClickDesk Live Chat Service for websites -->
<script type='text/javascript'>
var _glc =_glc || []; _glc.push('all_ag9zfmNsaWNrZGVza2NoYXRyDwsSBXVzZXJzGNDMsbYFDA');
var glcpath = (('https:' == document.location.protocol) ? 'https://my.clickdesk.com/clickdesk-ui/browser/' : 
'http://my.clickdesk.com/clickdesk-ui/browser/');
var glcp = (('https:' == document.location.protocol) ? 'https://' : 'http://');
var glcspt = document.createElement('script'); glcspt.type = 'text/javascript'; 
glcspt.async = true; glcspt.src = glcpath + 'livechat-new.js';
var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(glcspt, s);
</script>
<!-- End of ClickDesk -->
	</body>
</html>