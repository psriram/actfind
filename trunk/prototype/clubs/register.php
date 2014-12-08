<?php
check_login();
$layoutFile = 'layouts/templateSelf';
$Models_General = new Models_General();
$model = new Models_ActivityFinder();
$categoryDisplay = $model->category();

if (!empty($_POST)) {
  $arr = array();
  $arr['activity_id'] = guid();
  $arr['user_id'] = $_SESSION['user']['user_id'];
  $arr['ac_name'] = !empty($_POST['ac_name']) ? $_POST['ac_name'] : '';
  $arr['ac_description'] = !empty($_POST['ac_description']) ? $_POST['ac_description'] : '';
  $arr['ac_lat'] = !empty($_POST['lat']) ? $_POST['lat'] : '';
  $arr['ac_lon'] = !empty($_POST['lng']) ? $_POST['lng'] : '';
  $arr['ac_address'] = !empty($_POST['address']) ? $_POST['address'] : '';
  $arr['ac_updated'] = date('Y-m-d H:i:s');
  $arr['status'] = 1; //change this to 0 if integrated with payment.
  $arr['place_id'] = !empty($_POST['place_id']) ? $_POST['place_id'] : '';
  $category = !empty($_POST['category']) ? $_POST['category'] : array();
  $reviews = !empty($_POST['reviews']) ? $_POST['reviews'] : array();
  $arr['xtras'] = $_POST;
  if (isset($arr['xtras']['keyword'])) unset($arr['xtras']['keyword']);
  if (isset($arr['xtras']['category'])) unset($arr['xtras']['category']);
  if (isset($arr['xtras']['reviews'])) unset($arr['xtras']['reviews']);
  if (isset($arr['xtras']['submit'])) unset($arr['xtras']['submit']);
  if (isset($arr['xtras']['user_id'])) unset($arr['xtras']['user_id']);
  if (isset($arr['xtras']['place_id'])) unset($arr['xtras']['place_id']);
  if (empty($arr['xtras']['ac_images'])) unset($arr['xtras']['ac_images']);
  if (isset($arr['xtras']['lat'])) unset($arr['xtras']['lat']);
  if (isset($arr['xtras']['lng'])) unset($arr['xtras']['lng']);
  if (isset($arr['xtras']['address'])) unset($arr['xtras']['address']);
  if (!empty($arr['xtras']['ac_name'])) unset($arr['xtras']['ac_name']);
  if (!empty($arr['xtras']['ac_description'])) unset($arr['xtras']['ac_description']);
  for ($i = 1; $i <= 5; $i++) {
    $f = 'customfield'.$i;
    if (empty($arr['xtras'][$f])) unset($arr['xtras'][$f]);
  }
  for ($i = 0; $i <= 4; $i++) {
    if (empty($arr['xtras']['ac_images'][$i])) unset($arr['xtras']['ac_images'][$i]);
  }
  if (empty($arr['xtras']['ac_images'])) unset($arr['xtras']['ac_images']);
  $arr['xtras'] = json_encode($arr['xtras']);
  $Models_General->addDetails('activities', $arr, $_SESSION['user']['user_id']);
  if (!empty($category)) {
    $cats = array();
    $cats['activity_id'] = $arr['activity_id'];
    foreach ($category as $v) {
      $cats['category_id'] = $v;
      $Models_General->addDetails('activities_cats', $cats, $_SESSION['user']['user_id']);
    }
  }
  if (!empty($reviews)) {
    $rev = array();
    $rev['activity_id'] = $arr['activity_id'];
    foreach ($reviews as $v) {
      $rev['review_id'] = guid();
      $rev['show_review'] = !empty($v['show']) ? $v['show'] : '';
      $rev['author_name'] = !empty($v['author_name']) ? $v['author_name'] : '';
      $rev['rating'] = !empty($v['rating']) ? $v['rating'] : '';
      $rev['details'] = !empty($v['text']) ? $v['text'] : '';
      $rev['review_date'] = !empty($v['time']) ? date('Y-m-d H:i:s', $v['time']) : '';
      $rev['language_review'] = !empty($v['language']) ? $v['language'] : '';
      $Models_General->addDetails('club_reviews', $rev, $_SESSION['user']['user_id']);
    }
  }
  $msg = 'Club added successfully in our database.';
}
?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true&libraries=places"></script>
<style>
    #map-canvas {
        height: 300px;
        width: 100%;
        margin: 0px;
        padding: 0px
      }
      .form-inline .form-group { margin-right:10px; }
.well-primary {
color: rgb(255, 255, 255);
background-color: rgb(66, 139, 202);
border-color: rgb(53, 126, 189);
}
.glyphicon { margin-right:5px; }
    </style>
<script language="javascript" src="<?php echo HTTPPATH; ?>/scripts/business.js">
</script>
<script language="javascript">
$( document ).ready(function() {
    init();
});
</script>
<h3>Register A Club</h3>
<p><a href="/prototype/main">Back</a></p>
<form action="" method="post" name="formNew" id="formNew" style="width:900px;">
<p><?php if (!empty($msg)) echo $msg; ?></p>
<fieldset>
  <legend>Search My Club</legend>
  <p><b>Keyword: </b><input type="text" name="keyword" id="keyword" />
  </p>
  <p><input type="button" value="Find Businesses" style="width:100%" onclick="findBusiness()"></p>
  <div id="results">
  
  </div>
</fieldset>

  <fieldset>
    <legend><strong>Location</strong><a name="location"></a></legend>
    <div>
        <div id="latlng"></div>
        <input type="hidden" name="lat" id="lat" value="">
        <input type="hidden" name="lng" id="lng" value="">
        <input id="autocomplete" name="address" placeholder="Enter your address"
                                     onFocus="geolocate()" type="text" style="width:100%"></input>
        <div id="map-canvas"></div>
    </div>
  </fieldset>
  <fieldset>
    <legend><strong>Tagging / Category</strong></legend>
    <p>
      <select name="category[]" size="5" multiple="MULTIPLE" id="category" style="width:100%;">
      <?php if (!empty($categoryDisplay)) {
        foreach ($categoryDisplay as $v) {
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
      <label for="ac_name"><strong>League/Club Name:</strong></label>
      <br>
      <input type="text" name="ac_name" id="ac_name" style="width:100%;">
    </p>
    <p><strong>League/Club Description:</strong><br>
      <textarea name="ac_description" id="ac_description" style="width:100%" rows="5"></textarea>
    </p>
  </fieldset>
  <fieldset>
    <legend><strong>Images</strong></legend>
  <p>
    <label for="ac_images[]">Image url:</label>
    <input type="text" name="ac_images[]" style="width:100%"><br />
    <label for="ac_images[]">Image url:</label>
    <input type="text" name="ac_images[]" style="width:100%"><br />
    <label for="ac_images[]">Image url:</label>
    <input type="text" name="ac_images[]" style="width:100%"><br />
    <label for="ac_images[]">Image url:</label>
    <input type="text" name="ac_images[]" style="width:100%"><br />
    <label for="ac_images[]">Image url:</label>
    <input type="text" name="ac_images[]" style="width:100%"><br />
  </p>
  </fieldset>
  <fieldset>
    <legend><strong>Contact Info</strong></legend>
  <p>
    <label for="phone"><strong>Phone:</strong></label>
    <input type="text" name="phone" id="phone" style="width:100%">
  </p>
  <p>
    <label for="email"><strong>Email:</strong></label>
    <input type="text" name="email" id="email" style="width:100%">
  </p>
  <p>
    <label for="website"><strong>Website:</strong></label>
    <input type="text" name="website" id="website" style="width:100%">
  </p>
  <p>
    <label for="googleplus"><strong>Google Plus URL:</strong></label>
    <input type="text" name="googleplus" id="googleplus" style="width:100%">
  </p>
  <p>
    <label for="skype"><strong>Skype:</strong></label>
    <input type="text" name="skype" id="skype" style="width:100%">
  </p>
  <p>
    <label for="facebookURL"><strong>Facebook URL:</strong></label>
    <input type="text" name="facebookURL" id="facebookURL" style="width:100%">
  </p>
  <p>
    <input type="checkbox" name="whatsapp" id="whatsapp" value="1"> <strong>We are on Whatsapp?</strong>
    <input type="text" name="whatsapp_phone" id="whatsapp_phone" placeholder="Whats App Phone" />
  </p>
  </fieldset>
  
  <fieldset>
    <legend><strong>Fields</strong></legend>
    <div>
      <p><strong>Note:</strong> Fields for parents to enter.</p>
          <p>
            <label for="customfield1"><strong>Custom Field 1:</strong></label>
            <input type="text" name="customfield1" id="customfield1" style="width:100%;" placeholder="e.g. Students Name">
          </p>
          <p>
            <label for="customfield2"><strong>Custom Field 2:</strong></label>
            <input type="text" name="customfield2" id="customfield2" style="width:100%;" placeholder="e.g. Students Dob">
          </p>
          <p>
            <label for="customfield3"><strong>Custom Field 3:</strong></label>
            <input type="text" name="customfield3" id="customfield3" style="width:100%;" placeholder="e.g. Students Age">
          </p>
          <p>
            <label for="customfield4"><strong>Custom Field 4:</strong></label>
            <input type="text" name="customfield4" id="customfield4" style="width:100%;" placeholder="e.g. Students Gender">
          </p>
          <p>
            <label for="customfield5"><strong>Custom Field 5:</strong></label>
            <input type="text" name="customfield5" id="customfield5" style="width:100%;" placeholder="e.g. Students Address">
          </p>
    </div>
  </fieldset>
  
  <fieldset id="reviewsDisplay" style="display:none;">
    <legend><strong>Reviews</strong></legend>
    <div id="reviewsShow">
      
    </div>
  </fieldset>
    <p>
      <input type="hidden" name="place_id" id="place_id" value="" />
      <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['user']['user_id']; ?>" />
      <input type="submit" name="submit" id="submit" value="Submit" style="width:100%">
    </p>
</form>
