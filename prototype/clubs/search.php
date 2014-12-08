<?php
$layoutFile = 'layouts/templateSelf';
?>
<h3>Search Club</h3>
<p><a href="/prototype/main">Back</a></p>

<link href="<?php echo HTTPPATH; ?>/scripts/autocomplete/jquery.autocomplete.css" rel="stylesheet" type="text/css">
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true&libraries=places"></script>

<script language="javascript" src="<?php echo HTTPPATH; ?>/scripts/business.js">
</script>
<script language="javascript">
$( document ).ready(function() {
    init();
});
</script>
<style>
    #map-canvas {
        height: 300px;
        width: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>
<form action="" method="get" name="form1" id="form1" style="width:500px;">
<fieldset>
  <legend>Search My Club</legend>
  <p><b>Keyword: </b><input type="text" name="keyword" id="keyword" />
  </p>
</fieldset>
<fieldset>
  <legend>Near</legend>
  
    <div>
      <div><strong>Location</strong></div>
        <div id="latlng"></div>
        <input type="hidden" name="lat" id="lat" value="">
        <input type="hidden" name="lng" id="lng" value="">
        <input id="autocomplete" name="address" placeholder="Enter your address"
                                     onFocus="geolocate()" type="text" style="width:100%"></input>
        <div id="map-canvas"></div>
    </div>
</fieldset>

  <p><input type="button" value="Find Businesses" style="width:100%" onclick="finddbBusiness()"></p>
  <div id="resultsMain">
  
  </div>
  <div id="results">
  
  </div>
</form>