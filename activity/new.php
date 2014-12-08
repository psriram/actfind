<?php
//http://mkhancha.mkgalaxy.com/activity/new
check_login();

$pageTitle = 'New Activity Class';
$url = HTTPPATH.'/api/activity/category';
$content = curlget($url);
$categoryContent = json_decode($content, 1);
$category = !empty($categoryContent['data']) ? $categoryContent['data'] : array();

if (!empty($_POST)) {
  $url = HTTPPATH.'/api/activity/new';
  $params = array();
  $params = $_POST;
  $params['user_id'] = $_SESSION['user']['user_id'];
  $POSTFIELDS = http_build_query($params);
  $content = curlget($url, 1, $POSTFIELDS);
  $returnData = json_decode($content, 1);
  if (empty($returnData)) {
    $error = 'Server problem, please contact admin';
  } else {
    if ($returnData['success'] == 0) {
      $error = $returnData['msg'];
    } else {
      header("Location: ".HTTPPATH."/activity/confirm?msg=".urlencode($returnData['data']['confirm'])."&id=".$returnData['data']['id']);
      exit;
    }
  }
}

?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true"></script>
<style>
    #map-canvas {
        height: 300px;
        width: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>
<script language="javascript">
var geocoder;
var map;
var marker;
function showaddress(lat, lng)
{
  filllatlng(lat,lng)
  geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        //console.log(results);
        /*var len = (results[0].address_components).length;
        var zip =  results[0].address_components[(len-1)].short_name;
        var country =  results[0].address_components[(len-2)].short_name;
        var state =  results[0].address_components[(len-3)].short_name;
        var county =  results[0].address_components[(len-4)].short_name;
        var city =  results[0].address_components[(len-5)].short_name;
        $('#curCity').val(city);
        var addr = "lat: "+lat + "|lng:" + lng + "|addr:" + results[0].formatted_address + "|zip:" + zip + "|city:" + city + "|state:" + state + "|country:" + country + "|county:" + county;
        console.log(addr);*/
        $('#address').val(results[0].formatted_address);
      } else {
        //alert("Geocoder failed due to: " + status);
      }
    });
}
function codeAddress() {
  var address = document.getElementById('address').value;
  if (!address) {
    return false;
  }
  deleteMarkers();
  geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      /*map.setCenter(results[0].geometry.location);
      marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
      });*/
      showmap(results[0].geometry.location.lat(),results[0].geometry.location.lng());
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}

// Sets the map on all markers in the array.
function setAllMap(map) {
  marker.setMap(map);
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
  setAllMap(null);
}
// Deletes all markers in the array by removing references to them.
function deleteMarkers() {
  clearMarkers();
  marker = null;
}
function filllatlng(lat,lng)
{
  
  $('#latlng').html(lat + "," + lng);
  $('#lat').val(lat);
  $('#lng').val(lng);
}
function showmap(lat,lng)
{
  filllatlng(lat,lng);
  var myLatlng = new google.maps.LatLng(lat,lng);
  var mapOptions = {
    zoom: 17,
    center: myLatlng,
    panControl: true,
    zoomControl: true,
    scaleControl: true
  }
  map = new google.maps.Map(document.getElementById('map-canvas'),
                                mapOptions);
  marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
	  draggable:true,
  });
  
  google.maps.event.addListener(marker, 'dragend', function() {
    // 3 seconds after the center of the map has changed, pan back to the
    // marker.
	  
    showaddress(marker.getPosition().lat(), marker.getPosition().lng());
  });
}
function displayLocationold( lat, lng ) {
  showaddress(lat, lng);
  showmap(lat,lng);
}
function displayLocation( position ) {
  lata = position.coords.latitude;
  lona = position.coords.longitude;
  showaddress(lata, lona);
  showmap(lata,lona);
}

function handleError( error ) {
	var errorMessage = [ 
		'We are not quite sure what happened.',
		'Sorry. Permission to find your location has been denied.',
		'Sorry. Your position could not be determined.',
		'Sorry. Timed out.'
	];

	alert( errorMessage[ error.code ] );
  window.location.href = "/";
  
}
function initialize() {
    //var latitude = '<?php //echo !empty($latitude) ? $latitude : $globalCity['latitude']; ?>';
    //var longitude = '<?php //echo !empty($longitude) ? $longitude : $globalCity['longitude']; ?>';
    //displayLocationold(latitude, longitude);
    if ( navigator.geolocation ) {
      navigator.geolocation.getCurrentPosition( displayLocation, handleError );
    } else {
    alert("location is not enabled, please allow location access");
    window.location.href = "/";
  }
   
}
google.maps.event.addDomListener(window, 'load', initialize);

</script>
<form action="" method="post" name="formNew" id="formNew" style="width:500px;">
  <fieldset>
    <legend><strong>Location</strong></legend>
    <div>
        <div id="latlng"></div>
        <input type="hidden" name="lat" id="lat" value="">
        <input type="hidden" name="lng" id="lng" value="">
        <input type="text" name="address" id="address" style="width:70%;">
         <input type="button" value="Find Address" onclick="codeAddress()">
        <div id="map-canvas"></div>
    </div>
  </fieldset>
  <fieldset>
    <legend><strong>Tagging</strong></legend>
    <p>
      <label for="category">Choose Tagging:<br>
      </label>
      <select name="category[]" size="5" multiple="MULTIPLE" id="category" style="width:100%;">
      <?php if (!empty($category)) {
        foreach ($category as $v) {
          ?>
          <option value="<?php echo $v['category_id']; ?>"><?php echo $v['category']; ?></option>
          <?php
        }
      }
      ?>
      </select>
    </p>
  </fieldset>
  <fieldset><legend><strong>Details</strong></legend>
    <p>
      <label for="ac_name"><strong>Activity Class Name:</strong></label>
      <br>
      <input type="text" name="ac_name" id="ac_name" style="width:100%;">
    </p>
    <p><strong>Activity Class Description:</strong><br>
      <textarea name="ac_description" id="ac_description" style="width:100%" rows="5"></textarea>
    </p>
  </fieldset>
  <fieldset>
    <legend><strong>Images</strong></legend>
  <p>
    <label for="ac_images[]">Image url:</label>
    <input type="text" name="ac_images[]" id="ac_images" style="width:100%">
  </p>
  </fieldset>
    <p>
      <input type="submit" name="submit" id="submit" value="Submit" style="width:100%">
    </p>
</form>