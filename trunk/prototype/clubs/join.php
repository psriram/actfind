<?php


  $layoutFile = 'layouts/home/templateClub';
  $pageTitle = 'Join a club';


?>

<script type="text/javascript">
 $( document ).ready(function() {
  var class_counter = 2;
    $('#btnSaveLeague').on('click', function(){
            document.getElementById("formJoin").submit();
    });
    $('#btnLocationClass').on('click', function(){

        /*var id_label = "InputLocationClass" + class_counter;
        var newlabel = $(document.createElement('Label'))
         .attr("for", id_label);
        newlabel.innerHTML = "Class" + class_counter;
        newlabel.appendTo("#classBoxesGroup");*/

        var newTextBoxDiv = $(document.createElement('div'))
         .attr("class", 'input-group');

        newTextBoxDiv.after().html('<label for="InputClass' + class_counter + '"> Class ' + class_counter + '</label> <input type="text" name="InputClass' + class_counter +
              '" id="InputClass' + class_counter + '" placeholder="Enter Class Name" class="form-control" value="" >');

        newTextBoxDiv.appendTo("#classBoxesGroup");

        class_counter++;
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
          <ul class="nav navbar-nav navbar-left">
             <li class="active">Club Setup</li>
             <!-- <li><a href="#">Location Setup</a></li>
              <li><a href="#">Schedule Setup</a></li>-->
           </ul>
	        <ul class="nav navbar-nav navbar-right">
              <li class="active"><input type="button" name="btnSaveLeague" id="btnSaveLeague" value="Save" class="btn btn-info pull-right"></li>
	           <!-- <li><a href="#">Location Setup</a></li>
              <li><a href="#">Schedule Setup</a></li>-->
	         </ul>

	    </div>
   </div>
   <?php if($_REQUEST["error"]==1){ ?>
      <div id="divError" class="row text-center">
        Errors saving club.
      </div>
   <?php } ?>

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

                <div class="well well-sm"><strong><span><span>2 </span><span> Create Team </span></div>

                <div class="form-group">
                    <label for="InputTeamLocation">Team Location</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="InputTeamLocation" id="InputTeamLocation" placeholder="Enter Team Location" value="">
                   </div>
                </div>

                <div class="form-group" id='classBoxesGroup'>
                   <span><button type="button" id="btnLocationClass" class="btn btn-link">Add Class</button></span>

                    <div class="input-group" >
                         <label for="InputLocationClass1">Class 1</label>
                        <input type="text" class="form-control" name="InputClass1" id="InputClass1" placeholder="Enter Class Name" value="">
                    </div>
                </div>



            </div>
           <!-- <div id="map-canvas"></div>-->

            <!-- create team code-->


            <input type="hidden" name="lat" id="lat" value="">
            <input type="hidden" name="lng" id="lng" value="">
            <input type="hidden" name="place_id" id="place_id" value="" />

        </form>

    </div>
</div>