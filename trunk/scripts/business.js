
var geocoder;
var map;
var marker;
var markerX;
var ExistingPlaces = new Array();
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
        $('#autocomplete').val(results[0].formatted_address);
      } else {
        //alert("Geocoder failed due to: " + status);
      }
    });
}
function codeAddress() {
  var address = document.getElementById('autocomplete').value;
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

function finddbBusiness()
{
  ///api/activity/search?lat=37.7047798&lon=-121.91773360000002
  var url = "/api/activity/search?lat="+$('#lat').val()+"&lon="+$('#lng').val();

  if ($('#keyword').val()) {
    url = url + "&keyword=" + $('#keyword').val();
  }
  console.log(url);
  ExistingPlaces = new Array();
  var counter = 0;
  $.get( url, function( data ) {
    var obj = JSON.parse(data);
    if (obj.success == "1") {
        var objData = obj.data;
        var str = '<h2>Main Search Results</h2>';
        for (var key in objData) {
          var res = objData[key];
          console.log(res);
          var lat1 = res.ac_lat;
          var lon1 = res.ac_lon;
          var lat2 = parseFloat($('#lat').val());
          var lon2 = parseFloat($('#lng').val());
          var d = distance(lat1, lon1, lat2, lon2, 'M');
          d = $.number(d, 2);
          console.log('result: ' + lat1 + ", " + lon1 + ", " + lat2 + ", " + lon2 + ", " + d);
          str = str + '<div id="gbizMain_'+res.place_id+'"><b>' + res.ac_name + '</b> (' + res.distance + ' mi)<br>';
          str = str + '<b>Location: </b>' + res.ac_address + '<br>';
          str = str + '<a href="#">Detail</a><br><br></div>';//encodeURIComponent
          ExistingPlaces[counter] = res.place_id;
          counter++;
        }
        $('#resultsMain').html(str);
        findBusiness();
    } else {
      console.log(obj.msg);
    }
  });
}

function findBusiness()
{
  var loc = new google.maps.LatLng($('#lat').val(),$('#lng').val());
  var request = {
    location: loc,
    radius: 5000,
    rankby: 'distance'
  };
  if ($('#keyword').val()) {
    request.keyword = $('#keyword').val();
  }
  //console.log(request);
  infowindow = new google.maps.InfoWindow();
  var service = new google.maps.places.PlacesService(map);
  service.nearbySearch(request, callback);
}
var curResult;
function callback(results, status) {
  if (status == google.maps.places.PlacesServiceStatus.OK) {
    curResult = results;
    var str = '<h2>Search Results</h2>';
    for (var i = 0; i < results.length; i++) {
      console.log(results[i]);
      var lat1 = results[i].geometry.location.lat();
      var lon1 = results[i].geometry.location.lng();
      var lat2 = parseFloat($('#lat').val());
      var lon2 = parseFloat($('#lng').val());
      var d = distance(lat1, lon1, lat2, lon2, 'M');
      d = $.number(d, 2);
      console.log('result: ' + lat1 + ", " + lon1 + ", " + lat2 + ", " + lon2 + ", " + d);
      str = str + '<div id="gbiz_'+results[i].place_id+'"><b>' + results[i].name + '</b> (' + d + ' mi)<br>';
      str = str + '<b>Location: </b>' + results[i].vicinity + '<br>';
      str = str + '<a href="#location" onClick="chooseBusiness('+i+')">Own This Business</a><br><br></div>';//encodeURIComponent
    }
    $('#results').html(str);
    //removing existing places
    var len = ExistingPlaces.length;
    if (len > 0) {
      console.log(ExistingPlaces);
      for (i = 0; i < len; i++) {
        $('#gbiz_'+ExistingPlaces[i]).hide()
      }
    }
  } else {
    alert('No result found. Do you like to add this business');
  }
}
function chooseBusiness(num)
{
  var res = curResult[num];
  console.log(res);
  var lat1 = res.geometry.location.lat();
  var lon1 = res.geometry.location.lng();
  showaddress(lat1, lon1);
  showmap(lat1,lon1);
  $('#ac_name').val(res.name);
  $('#place_id').val(res.place_id);
  var placeRequest = {
    placeId: res.place_id
  };

  service = new google.maps.places.PlacesService(map);
  service.getDetails(placeRequest, callbackDetails);
}

  function callbackDetails(place, status) {
    if (status == google.maps.places.PlacesServiceStatus.OK) {
      console.log(place);
      $('#phone').val(place.formatted_phone_number);
      $('#website').val(place.website);
      $('#googleplus').val(place.url);
      if (place.reviews) {
          var reviews = place.reviews;
          reviewsStr = '';
          if (reviews.length > 0) {
            $('#reviewsDisplay').show();
            for (i = 0; i < reviews.length; i++) {
              reviewsStr = reviewsStr + '<p>';
              reviewsStr = reviewsStr + '<input type="checkbox" name="reviews['+i+'][show]" value="1" checked />Show This Review To User<br />';
              if (reviews[i].text) {
                reviewsStr = reviewsStr + reviews[i].text+'<br />';
              }
              reviewsStr = reviewsStr + '<b>Rating: </b>' + reviews[i].rating;
              reviewsStr = reviewsStr + '<input type="hidden" name="reviews['+i+'][author_name]" value="'+reviews[i].author_name+'" />';
              reviewsStr = reviewsStr + '<input type="hidden" name="reviews['+i+'][rating]" value="'+reviews[i].rating+'" />';
              reviewsStr = reviewsStr + '<input type="hidden" name="reviews['+i+'][text]" value="'+reviews[i].text+'" />';
              reviewsStr = reviewsStr + '<input type="hidden" name="reviews['+i+'][time]" value="'+reviews[i].time+'" />';
              reviewsStr = reviewsStr + '<input type="hidden" name="reviews['+i+'][language]" value="'+reviews[i].language+'" />';
              reviewsStr = reviewsStr + '</p>';
            }
            $('#reviewsShow').html(reviewsStr);
          } else {
            $('#reviewsDisplay').hide();
          }
      }
    }
  }

function distance(lat1, lon1, lat2, lon2, unit) {
  var radlat1 = Math.PI * lat1/180
  var radlat2 = Math.PI * lat2/180
  var radlon1 = Math.PI * lon1/180
  var radlon2 = Math.PI * lon2/180
  var theta = lon1-lon2
  var radtheta = Math.PI * theta/180
  var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
  dist = Math.acos(dist)
  dist = dist * 180/Math.PI
  dist = dist * 60 * 1.1515
  if (unit=="K") { dist = dist * 1.609344 }
  if (unit=="N") { dist = dist * 0.8684 }
  return dist
}


var placeSearch, autocomplete;
var componentForm = {
  street_number: 'short_name',
  route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name'
};
function init() {
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

function fillInAddress() {
      // Get the place details from the autocomplete object.
      var place = autocomplete.getPlace();
      lat = place.geometry.location.lat();
      lng = place.geometry.location.lng();

      showmap(lat,lng);
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
$( document ).ready(function() {

    $('#lnkChangeLoc').on('click', function(){
      $("#loc1").show();
        //window.location.href="/prototype/users/logout";
    });
    function validateForm()
    {
      return true;

    }
});
google.maps.event.addDomListener(window, 'load', initialize);