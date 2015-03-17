<?php


  $layoutFile = 'layouts/home/templateClub';
  $pageTitle = 'Join a club';
  $model = new Models_ActivityFinder();
  $categoryDisplay = $model->category();

?>

<script type="text/javascript">
 $( document ).ready(function() {

    $('#btnSaveLeague').on('click', function(){
            document.getElementById("formJoin").submit();
    });

 });
</script>
 <style>
      /*#map-canvas {
        height: 400px;
        width: 100%;
        margin: 0px;
        padding: 0px
      }*/
    .red {
      color: red;
    }
</style>


<div class="container">
<?php
  $file = SITEDIR.'/includes/club_join_header.php';

  if (file_exists($file)) {
    include_once($file);
  }
?>
 <link href="<?php echo HTTPPATH; ?>/scripts/autocomplete/jquery.autocomplete.css" rel="stylesheet" type="text/css">
 <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>

 <script>
    // This example displays an address form, using the autocomplete feature
    // of the Google Places API to help users fill in the information.

    var placeSearch, autocomplete;
    var componentForm = {
      street_number: 'short_name',
      route: 'long_name',
      locality: 'long_name',
      administrative_area_level_1: 'short_name',
      country: 'long_name',
      postal_code: 'short_name'
    };
    initialize('autocomplete1','hdnLat1','hdnLong1');
    function initialize(elem,lat,lng) {
      // Create the autocomplete object, restricting the search
      // to geographical location types.
      autocomplete = new google.maps.places.Autocomplete(
          /** @type {HTMLInputElement} */(document.getElementById(elem)),
         { types: ['geocode'] });
        // { types: ['(cities)'] });
      // When the user selects an address from the dropdown,
      // populate the address fields in the form.
      google.maps.event.addListener(autocomplete, 'place_changed', function() {
        fillInAddress(lat,lng);
      });
    }

    // [START region_fillform]
    function fillInAddress(lat,lng) {
      // Get the place details from the autocomplete object.
      var place = autocomplete.getPlace();
      document.getElementById(lat).value = place.geometry.location.lat();
      document.getElementById(lng).value = place.geometry.location.lng();

    }

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
         #controls {
            position: relative;
            width: 480px;
          }
          /*#autocomplete {
            position: absolute;
            top: 0px;
            left: 0px;
            width: 80%;
          }*/
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
         .locationField{
             position: relative;
             width: 480px;
             height: 20px;
             margin-bottom: 2px;
          }
          .classField{
             position: relative;
             width: 280px;
             height: 20px;
             margin-bottom: 2px;
          }
          .scheduleField{
             position: relative;
             width: 280px;
             height: 20px;
             margin-bottom: 2px;
          }
        </style>


	<div class="row text-center">
     <p></p>
    </div>
     <div class="row text-center">
     <p></p>
    </div>
     <hr />
    <div class="row">
        <form role="form" method="post" name="formJoin" id="formJoin" action="/activityfinder/prototype/clubs/saveclub">
            <div class="col-lg-6">
                <div class="well well-sm"><strong><span><span>1 </span><span> Club Details </span></div>

                <div class="form-group">
                    <label for="InputName">Club Name</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="InputName" id="InputName" placeholder="Enter Name" value="<?php echo isset($_POST['InputName']) ? $_POST['InputName'] : '' ?>" required>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>

                 <div class="form-group">
                    <label for="InputName">Club Phone</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="InputPhone" id="InputPhone" placeholder="Enter Phone" value="<?php echo isset($_POST['InputPhone']) ? $_POST['InputPhone'] : '' ?>" required>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>

                <div class="form-group">
                   <label>Club Category</label>
                     <?php if (!empty($categoryDisplay)) {
                      foreach ($categoryDisplay as $v) {
                        ?>
                        <div class="checkbox">
                          <label><input type="checkbox" name="category[]" value="<?php echo $v['category_id']; ?>"><?php echo $v['category']; ?></label>
                        </div>
                      <?php
                      }
                    }
                  ?>
                </div>
                <div id="locfindgroup" class="form-group">
                     <label for="autocomplete1">Locations</label>
                    <div class="input-group locationField">
                       <input id="autocomplete1" name="autocomplete1" placeholder="Enter Location 1"
                                                     onFocus="geolocate()" type="text" class="form-control" required></input>
                        <input type="hidden" id="hdnLat1" name="hdnLat1"/>
                        <input type="hidden" id="hdnLong1" name="hdnLong1"/>

                    </div>
                </div>
                <div class="form-group">
                   <!--<button type="button" id="btnFindLocation" class="btn btn-link">Cannot Find Location</button>-->
                    <button type="button" id="btnAddLocation" class="btn btn-link">Add Location</button>
                </div>

                <div id="divClass" class="form-group">
                     <label for="InputClass1">Class/Team</label>
                      <div class="row">
                        <div class="col-sm-6"><input type="text" class="form-control" name="InputClass1" id="InputClass1" placeholder="Enter Class" value="" required></div>
                        <div class="col-sm-3"><input type="text" class="form-control" name="InputStartAge1" id="InputStartAge1" placeholder="Enter Start Age" value=""></div>
                        <div class="col-sm-3"><input type="text" class="form-control" name="InputEndAge1" id="InputEndAge1" placeholder="Enter End Age" value=""></div>
                      </div>
                     <!--<div class="input-group classField">
                        <input type="text" class="form-control" name="InputClass1" id="InputClass1" placeholder="Enter Class" value="" required>
                        <input type="text" class="form-control" name="InputStartAge1" id="InputStartAge1" placeholder="Enter Start Age" value="">
                        <input type="text" class="form-control" name="InputEndAge1" id="InputEndAge1" placeholder="Enter End Age" value="">
                    </div>-->
                </div>
                <div class="form-group">

                    <button type="button" id="btnAddClass" class="btn btn-link">Add Class/Team</button>
                </div>
                <div id="divSchedule" class="form-group">
                     <label for="InputClass1">Club Schedule</label>
                     <div class="input-group classField">
                        <input type="text" class="form-control" name="InputSchedule1" id="InputSchedule1" placeholder="Enter Schedule Name" value="" required>
                    </div>
                </div>
                <div class="form-group">

                    <button type="button" id="btnAddSchedule" class="btn btn-link">Add Schedule</button>
                </div>
               <!-- <div id="locationgroup" class="form-group" style="display:none">
                   <div class="row">
                        <div class="col-sm-4">Address</div>
                        <div class="col-sm-4">City</div>
                        <div class="col-sm-4">State</div>
                    </div>
                    <div class="row" >
                          <div class="col-sm-4"><input type="text" class="form-control" name="InputAddress" id="InputAddress" placeholder="Enter Address" value=""></div>
                          <div class="col-sm-4"><input type="text" class="form-control" name="InputCity" id="InputCity" placeholder="Enter City" value=""></div>
                          <div class="col-sm-4"><input type="text" class="form-control" name="InputState" id="InputState" placeholder="Enter State" value=""></div>
                    </div>

                </div>-->
                <div class="form-group">
                  <label for="InputWebSite">Website</label>

                  <div class="input-group">
                      <input type="text" class="form-control" name="InputWebsite" id="InputWebSite" placeholder="Enter Website" value="<?php echo isset($_POST['InputWebsite']) ? $_POST['InputWebsite'] : '' ?>">
                      <span class="input-group-addon"><span class=""></span></span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="InputDetails">Details</label>
                  <div class="input-group">
                      <textarea class="form-control" id="InputDetails" name="InputDetails" placeholder="Enter Details" cols="68" rows="7"><?php echo isset($_POST['InputDetails']) ? $_POST['InputDetails'] : '' ?></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <div class="input-group">
                     <input type="button" name="btnSaveLeague" id="btnSaveLeague" value="Next" class="btn btn-info pull-right">
                  </div>
                </div>

            </div>
            <!--<div id="map-canvas"></div>-->

            <!-- create team code-->


            <input type="hidden" name="locationCounter" id="locationCounter" value="">
            <input type="hidden" name="classCounter" id="classCounter" value="">
            <input type="hidden" name="scheduleCounter" id="scheduleCounter" value="">
        </form>

    </div>
</div>