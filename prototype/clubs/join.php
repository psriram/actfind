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



                <div id="locfind" class="form-group">
                    <label for="InputLocation">Location</label>
                    <div id="locationField" class="input-group">


                        <input id="autocomplete" name="InputLocation" id="InputLocation" placeholder="Location"
                                                     onFocus="geolocate()" type="text" class="form-control" required></input>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>

                    </div>

                </div>
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


            <input type="hidden" name="lat" id="lat" value="">
            <input type="hidden" name="lng" id="lng" value="">
            <input type="hidden" name="place_id" id="place_id" value="" />

        </form>

    </div>
</div>