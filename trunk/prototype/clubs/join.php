<?php
  $layoutFile = 'layouts/home/templateClub';
  $pageTitle = 'Join a club';
  $Models_General = new Models_General();
  $model = new Models_ActivityFinder();
  $categoryDisplay = $model->category();

  /*$layoutFile = 'layouts/templateSelf';
$Models_General = new Models_General();
$model = new Models_ActivityFinder();
$categoryDisplay = $model->category();*/
print_r($_SESSION);
exit;
if (!empty($_POST)) {
  $arr = array();
  $arr['activity_id'] = guid();
  $arr['user_id'] = $_SESSION['user']['user_id'];
  $arr['ac_name'] = !empty($_POST['InputName']) ? $_POST['InputName'] : '';
  $arr['ac_email'] = !empty($_POST['InputEmail']) ? $_POST['InputEmail'] : '';
  $arr['ac_password'] = !empty($_POST['InputPassword']) ? $_POST['InputPassword'] : '';
  $arr['ac_lat'] = !empty($_POST['lat']) ? $_POST['lat'] : '';
  $arr['ac_lon'] = !empty($_POST['lng']) ? $_POST['lng'] : '';
  print_r($arr);
  exit;
  /*
  if(!empty($_POST['InputLocation'])){
    $arr['ac_address'] = $_POST['InputLocation'];
  }
  else{
    $address = empty($_POST['InputAddress']) ? $_POST['InputAddress'] : '';
    $city = empty($_POST['InputCity']) ? $_POST['InputCity'] : '';
    $state = empty($_POST['InputState']) ? $_POST['InputState'] : '';
    $zipcode = empty($_POST['InputZipCode']) ? $_POST['InputZipCode'] : '';
    $arr['ac_address'] = $address.",".$city.",".$state.",".$zipcode;
  }
  $arr['ac_updated'] = date('Y-m-d H:i:s');
  $arr['status'] = 1; //change this to 0 if integrated with payment.
  $arr['place_id'] = !empty($_POST['place_id']) ? $_POST['place_id'] : '';
  $arr['details'] = !empty($_POST['InputMessage']) ? $_POST['InputMessage'] : '';
  $category = !empty($_POST['InputCategory']) ? $_POST['InputCategory'] : array();
  $Models_General->addDetails('activities', $arr, $_SESSION['user']['user_id']);
  if (!empty($category)) {
    $cats = array();
    $cats['activity_id'] = $arr['activity_id'];
    foreach ($category as $v) {
      $cats['category_id'] = $v;
      $Models_General->addDetails('activities_cats', $cats, $_SESSION['user']['user_id']);
    }
  }

  $msg = 'Club added successfully in our database.';*/

}
?>


 <style>
  #map-canvas {
        height: 400px;
        width: 100%;
        margin: 0px;
        padding: 0px
      }
    .red {
      color: red;
    }
</style>


<div class="container">
 	<div class="navbar navbar-default">
		 <div class="navbar-header">
	        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	        </button>
	        <a class="navbar-brand" href="#"></a>
	    </div>
	    <div id="navbar" class="collapse navbar-collapse">
	        <ul class="nav navbar-nav navbar-right">
	            <li class="active"><a href="#">Save</a></li>
	            <li><a href="#">Design</a></li>
	            <li><a href="#">Setup</a></li>
	            <li><a href="#">Preview</a></li>
	        </ul>

	    </div>
   </div>

	<div class="row text-center">
     <p></p>
    </div>
     <div class="row text-center">
     <p></p>
    </div>
     <hr />
    <div class="row">
        <form role="form" action="" method="post" name="formNew" id="formNew" onSubmit="return validateForm();">
            <div class="col-lg-6">
                <div class="well well-sm"><strong><span class="glyphicon glyphicon-asterisk"></span>Required Field</strong></div>
                <div class="form-group">
                    <label for="InputName">Club Name</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="InputName" id="InputName" placeholder="Enter Name" required>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="InputEmail">Club Email</label>
                    <div class="input-group">
                        <input type="email" class="form-control" id="InputEmail" name="InputEmail" placeholder="Enter Email" required>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>
                 <div class="form-group">
                    <label for="InputPassword">Club Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="InputPassword" name="InputPassword" placeholder="Enter Password" required>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>
                <div id="locfind" class="form-group">
                    <label for="InputLocation">Location</label>
                    <div id="locationField" class="input-group">


                        <input id="autocomplete" name="InputLocation" placeholder="Location"
                                                     onFocus="geolocate()" type="text" class="form-control" required></input>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>

                    </div>

                </div>

                <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-right">
            </div>

            <div id="map-canvas"></div>
            <input type="hidden" name="lat" id="lat" value="">
            <input type="hidden" name="lng" id="lng" value="">
            <input type="hidden" name="place_id" id="place_id" value="" />

        </form>

    </div>
</div>