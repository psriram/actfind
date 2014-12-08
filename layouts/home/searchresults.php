

<!DOCTYPE html>
<html>
  <head>
    <title>Place searches</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">

    <base href="<?php echo HTTPPATH; ?>/layouts/home/" />
        <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>



    <script>
var map;
var infowindow;
var listingstr = '';
function initialize() {
  var lat = "<?php echo $_POST['hdnLat'];?>";
  var lng = "<?php echo $_POST['hdnLong'];?>";
  var rad = "<?php echo $_POST['hdnRadius'];?>";
  var cat = "<?php echo $_POST['keywords'];?>";
  var rad = 5;
  lat = parseFloat(lat);
  lng = parseFloat(lng);
  rad = parseInt(rad) * 1609
  //cat = "karate";
  alert(lat);
  alert(lng);
  alert(rad);
  alert(cat);
  var pyrmont = new google.maps.LatLng(lat, lng);

  map = new google.maps.Map(document.getElementById('map'), {
    center: pyrmont,
    zoom: 8
  });

  var request = {
    location: pyrmont,
    radius: rad,
    keyword: cat
    //types: ['store']
  };
  infowindow = new google.maps.InfoWindow();
  var service = new google.maps.places.PlacesService(map);
  service.nearbySearch(request, callback);
}

function callback(results, status) {
  $('#grdListings').html('');
  if (status == google.maps.places.PlacesServiceStatus.OK) {
    for (var i = 0; i < results.length; i++) {
      createMarker(results[i]);
      createListing(results[i]);
    }


  }
}

function createMarker(place) {
  //console.log(place);
  var placeLoc = place.geometry.location;

  var marker = new google.maps.Marker({
    map: map,
    position: place.geometry.location
  });

  google.maps.event.addListener(marker, 'click', function() {
    infowindow.setContent(place.name);
    infowindow.open(map, this);
  });
}

function createListing(place){

    var name = place.name;
    var place_id = place.place_id;
    var request = {
      placeId: place_id
    };
    //console.log(request);
    var service1 = new google.maps.places.PlacesService(map);
    service1.getDetails(request, callbackdetail);
}

function callbackdetail(place,status){

  if (status == google.maps.places.PlacesServiceStatus.OK) {
    var address = place.vicinity;
    var url = place.url;
    var rating = place.rating;
    var reviews = place.reviews;
    var phone = place.formatted_phone_number;
    var photos = place.photos;
    var opening_hours = place.opening_hours;
    var list = "<div class='row'> \
                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'> \
                    <div class='panel panel-default' onclick='return init_map(0);'> \
                        <div class='row padall'> \
                            <div class='col-xs-12 col-sm-12 col-md-3 col-lg-3'> \
                                <span></span> \
                                <img src='img/work-10.jpg' /> \
                            </div> \
                            <div class='col-xs-12 col-sm-12 col-md-9 col-lg-9'> \
                                <div class='clearfix'> \
                                    <div class='pull-left'> \
                                        <span class='fa fa-dollar icon'> " + name + "</span> \
                                    </div> \
                                    <div class='pull-right'> " +
                                        url
                                   + "</div> \
                                </div> \
                                <div> \
                                    <h4><span class='fa fa-map-marker icon'></span>" + address + "</h4>" +
                                    phone + "<span class='fa fa-lock icon pull-right'> "+ + "</span> \
                                </div> \
                            </div> \
                        </div> \
                    </div> \
                </div> \
            </div>"
    console.log(list);
    $('#grdListings').append(list);

  }

}
google.maps.event.addDomListener(window, 'load', initialize);

</script>
  </head>
  <body>
    <div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 " id="grdListings">

        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="row padbig">
                <div id="map" class="map">
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .gmnoprint img {
    max-width: none;
    }

    .panel:hover {
        background-color: rgb(237, 245, 252);
    }

    .map {
        min-width: 300px;
        min-height: 470px;
        width: 100%;
        height: 100%;
    }

    img {
        max-width: 110%;
        height: auto;
    }

    .clearfix {
        clear: both;
    }

    .rowcolor {
        background-color: #CCCCCC;
    }

    .padall {
        padding: 10px;
    }

    .padbig {
        padding: 20px;
    }

    .icon {
        font-size: 23px;
        color: #197BB5;
    }
</style>
  </body>
</html>

