<?php


  $layoutFile = 'layouts/home/templateClub';
  $pageTitle = 'Location Setup';

  //echo("club id:".  $_SESSION['club_id']);
?>

<script type="text/javascript">
 $( document ).ready(function() {
  $('#btnLocationClass').on('click', function(){
          //$("#divClass").css("display", "none");
          $('#divClass').show();
  });

 });
</script>
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
              <li class="active"><input type="button" name="btnSaveLocation" id="btnSaveLocation" value="Location Setup" class="btn btn-info pull-right"></li>
	        </ul>
      </div>
   </div>
  <div id="divError" class="row text-center">

  </div>
	<div class="row text-center">
     <p></p>
    </div>
     <div class="row text-center">
     <p></p>
    </div>
     <hr />
    <div class="row">
        <form role="form" method="post" name="formLocation" id="formLocation" action="/activityfinder/prototype/clubs/saveclub?action=location">
            <div class="col-lg-6">
                <div class="well well-sm"><strong><span class="glyphicon glyphicon-asterisk"></span>Required Field</strong></div>
                <div class="form-group">
                    <label for="InputName">Location</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="InputName" id="InputLocation" placeholder="Enter Location" value="<?php echo isset($_POST['InputLocation']) ? $_POST['InputLocation'] : '' ?>" required>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>
                 <span><<button type="button" id="btnLocationClass" class="btn btn-link">Add Class</button></span>
                 <div id = "divClass" style="display: none;" class="form-group">
                    <label for="InputName">Location Class/Team</label>
                    <div class="input-group">
                        <div class="checkbox">
                             <label><input type="checkbox" value="">School Year</label>
                        </div>
                        <div class="checkbox">
                          <label><input type="checkbox" value="">Summer</label>
                        </div>
                        <div class="checkbox disabled">
                          <label><input type="checkbox" value="" disabled>Spring</label>
                        </div>
                    </div>
                </div>
              <!--
                <span><a id="lnkSetup" style="display: none;" href="#">Add Setup</a></span>
                 <div id = "divSetup" style="display: none;" class="form-group">
                    <label for="InputName">Location Setup</label>
                    <div class="input-group">
                        <div class="checkbox">
                             <label><input type="checkbox" value="">School Year</label>
                        </div>
                        <div class="checkbox">
                          <label><input type="checkbox" value="">Summer</label>
                        </div>
                        <div class="checkbox disabled">
                          <label><input type="checkbox" value="" disabled>Spring</label>
                        </div>
                    </div>
                </div>
            -->

        </form>

    </div>
</div>