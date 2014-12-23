
    <div class="panel panel-warning">
      <div class="panel-heading">Search</div>
      <div class="panel-body">
      <form action="" method="get" name="frmSearch" id="frmSearch">

<script language="javascript">

//autocomplete

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
        /** @type {HTMLInputElement} */(document.getElementById('address')),
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
    $('#lat').val(lat);
    $('#lng').val(lng);
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
  init();
});
</script>
      <div class="form-group">
          <strong>Keyword:</strong><br />
          <input type="text" name="keyword" class="inputText" value="<?php if (isset($_GET['keyword'])) echo $_GET['keyword']; ?>"/>
      </div>
      <?php foreach ($resultModuleFields as $k => $v) { ?>
        <?php if ($v['searchable'] == 0) continue; ?>
        <?php if ($v['field_type'] == 'double' || $v['field_type'] == 'int') { ?>
            <div class="form-group">
                <strong><?php echo !empty($v['search_display_name']) ? $v['search_display_name'] : $v['field_display_name']; ?></strong> (Min)<br />
                <input type="text" name="<?php echo $v['field_name']; ?>[min]" class="inputText" value="<?php if (isset($_GET[$v['field_name']]['min'])) echo $_GET[$v['field_name']]['min']; ?>"/>
            </div>
            <div class="form-group">
                <strong><?php echo !empty($v['search_display_name']) ? $v['search_display_name'] : $v['field_display_name']; ?></strong> (Max)<br />
                <input type="text" name="<?php echo $v['field_name']; ?>[max]" class="inputText" value="<?php if (isset($_GET[$v['field_name']]['max'])) echo $_GET[$v['field_name']]['max']; ?>"/>
            </div>
        <?php } ?>
        <?php if ($v['field_type'] == 'checkbox') {?>
            <div class="form-group">
                <strong><?php echo !empty($v['search_display_name']) ? $v['search_display_name'] : $v['field_display_name']; ?></strong><br />
                <input type="radio" name="<?php echo $v['field_name']; ?>" value="1" <?php if (isset($_GET[$v['field_name']]) || !empty($_GET[$v['field_name']])) echo 'checked'; ?>/> Yes
                <input type="radio" name="<?php echo $v['field_name']; ?>" value="0" <?php if (isset($_GET[$v['field_name']]) && empty($_GET[$v['field_name']])) echo 'checked'; ?>/> No
            </div>
        <?php } ?>
        
        <?php if ($v['field_type'] == 'addressbox' && $v['searchable']) { ?>
            <div class="form-group">
                <strong>Search All Location:</strong>
                <input id="wholeworld" name="wholeworld" <?php echo !empty($_GET['wholeworld']) ? 'checked' : ''; ?> type="checkbox" value="1">
            </div>
            <div class="form-group">
                <strong>Near:</strong><br />
                <input id="address" name="address" value="<?php echo !empty($_GET['address']) ? $_GET['address'] : ''; ?>"
                                     onFocus="geolocate()" type="text" class="inputText addressBox">
            </div>
            <div class="form-group">
                <strong>Radius (mi):</strong><br />
                <input type="text" name="radius" id="radius" value="<?php echo isset($_GET['radius']) ? $_GET['radius'] : '30'; ?>"  class="inputText" />
            </div>
            <input type="hidden" name="lat" id="lat" value="<?php echo !empty($_GET['lat']) ? $_GET['lat'] : ''; ?>" />
            <input type="hidden" name="lng" id="lng" value="<?php echo !empty($_GET['lng']) ? $_GET['lng'] : ''; ?>" />
        <?php } ?>
        
        <?php if ($v['field_type'] == 'selectbox' && $v['searchable']) { 
        $options = json_decode($v['related_information'], 1);
        ?>
            <div class="form-group">
                <strong><?php echo !empty($v['search_display_name']) ? $v['search_display_name'] : $v['field_display_name']; ?></strong><br />
                <i style="font-size:10px;">Choose Single or Multiple:</i><br />
                <select name="<?php echo $v['field_name']; ?>[]" size="5" multiple class="inputText">
                  <?php foreach ($options as $k1 => $v1) { ?>
                  <option value="<?php echo $k1; ?>" <?php echo (!empty($_GET[$v['field_name']]) && in_array($k1, $_GET[$v['field_name']])) ? 'selected' : ''; ?>><?php echo $v1; ?></option>
                  <?php } ?>
                </select>
            </div>
        <?php } ?>
        
        <?php if ($v['field_type'] === 'multipleselectbox' && $v['searchable']) {
            $options = json_decode($v['related_information'], 1);
            $fieldOptions = $_GET[$v['field_name']];
          ?>
            <div class="form-group">
              <strong><?php echo $v['field_display_name']; ?></strong><br />
              <select name="<?php echo $v['field_name']; ?>[]" multiple size="5" class="inputText">
                <?php foreach ($options as $k1 => $v1) { ?>
                <option value="<?php echo $k1; ?>" <?php echo (!empty($_GET[$v['field_name']]) && in_array($k1, $fieldOptions)) ? 'selected' : ''; ?>><?php echo $v1; ?></option>
                <?php } ?>
              </select>
            </div>
        <?php } ?>
        
      <?php } ?>
      <div class="form-group">
          <input type="hidden" name="module_id" id="module_id" value="<?php echo !empty($_GET['module_id']) ? $_GET['module_id'] : ''; ?>" />
          <input type="submit" name="submit" id="submit" value="Submit" class="inputText">
      </div>
      </form>
      </div>
    </div>