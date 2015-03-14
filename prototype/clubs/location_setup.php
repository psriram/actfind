<?php


  $layoutFile = 'layouts/home/templateClub';
  $pageTitle = 'Join a club';
  $model = new Models_General();
  $params['where'] = " and Club_Id=".$model->qstr($_SESSION['club_id']);
  $clubLocations = $model->getDetails('club_location',$params);
 //pr($clubLocations);

?>

<script type="text/javascript">
function copySchedule(class_schedule_id){
    var data = 'id='+ class_schedule_id
     $.ajax({
                url: "/activityfinder/prototype/clubs/getschedule",
                type: "GET",
                data: data,
                success: function(d) {
                    var obj = JSON.parse(d);
                }
            });
}
 $( document ).ready(function() {
    //var class_counter = 2;

    $('#sltClubLocation li a').on('click', function(){
      //alert(this);
      var selectedOption = $(this).attr('data-value');
      //alert(selectedOption);
      //alert(selectedOption);
      $('#locKeywords').val($(this).text().trim());
      $('#hdnLocation').val(selectedOption);

    });

    $('#btnAddLocationClass').on('click', function(){
        var location_val = $("#locKeywords").val().trim();
        if(location_val==""){
          alert("Please select location");
          $("#locKeywords").focus();
          return false;
        }

        $.ajax({
                url: "/activityfinder/prototype/clubs/saveschedule",
                type: "post",
                data: $("#formSchedule").serialize(),
                success: function(d) {
                    $('#div1').html(d);
                }
            });

    });

 });
</script>
 <style>

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
        <form role="form" method="post" name="formSchedule" id="formSchedule" action="/activityfinder/prototype/clubs/saveschedule">
        <div class="col-sm-12">

            <div class="well well-sm"><strong><span>Create Team </span></div>

            <div class="form-group">

                     <?php if (!empty($clubLocations)) { ?>
                    <div class="dropdown">
                         <input
                                    id="locKeywords"
                                    class="dropdown-toggle"
                                    data-toggle="dropdown"
                                    type="text"
                                    name="lockeywords"
                                    size="50"
                                    maxlength="100"
                                    value=""
                                    placeholder="Select Location"
                                    />

                         <ul class="dropdown-menu" id="sltClubLocation">
                        <?php
                          foreach ($clubLocations as $v) {
                            ?>

                              <li role="presentation"><a role="menuitem" href="javascript:;" data-value="<?php echo $v['Club_Location_Id']; ?>" data-copy="<?php echo $v['Club_Location_Id']; ?>">
                              <?php echo $v['location']; ?>
                              </a></li>

                          <?php
                          }?>
                           </ul>
                           <input type="hidden" id="hdnLocation" name="hdnLocation" value=""/>
                    </div>

                        <?php
                        }
                      ?>
            </div>
           <!-- <div class="form-group">
                <label for="InputTeamLocation">Team Location</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="InputTeamLocation" id="InputTeamLocation" placeholder="Enter Team Location" value="">
               </div>
            </div>-->


            <div class="panel panel-default">
                  <div class="panel-heading">
                      <h3 class="panel-title">
                          <span class="fa fa-question-circle"></span> Schedule Setup</h3>
                  </div>
                  <div class="panel-body two-col">
                        <div class="form-group" id='classBoxesGroup'>



                            <div class="row">
                              <div class="col-sm-2">Class Name</div>
                              <div class="col-sm-2">Start Age</div>
                              <div class="col-sm-2">End Age</div>
                              <div class="col-sm-2">Start Date</div>
                              <div class="col-sm-2">End Date</div>
                              <div class="col-sm-2">#Sessions</div>
                            </div>
                            <div class="row" >
                                <div class="col-sm-2"><input type="text" class="form-control" name="InputClass" id="InputClass" placeholder="Enter Class Name" value=""></div>
                                <div class="col-sm-2"><input type="text" class="form-control" name="InputStartAge" id="InputStartAge" placeholder="Enter Start Age" value=""></div>
                                <div class="col-sm-2"><input type="text" class="form-control" name="InputEndAge" id="InputEndAge" placeholder="Enter End Age" value=""></div>
                                <div class="col-sm-2">
                                  <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' class="form-control" name="InputStartDate" id="InputStartDate"/>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                  </div>
                                </div>
                                 <script type="text/javascript">
                                    $(function () {
                                        $('#datetimepicker1').datetimepicker({
                                            format: 'MM/DD/YY'
                                        });
                                    });
                                </script>

                                <div class="col-sm-2">
                                  <div class='input-group date' id='datetimepicker2'>
                                    <input type='text' class="form-control" name="InputEndDate" id="InputEndDate"/>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                  </div>
                                </div>
                                 <script type="text/javascript">
                                    $(function () {
                                        $('#datetimepicker2').datetimepicker({
                                            format: 'MM/DD/YY'
                                        });
                                    });
                                </script>


                                <div class="col-sm-2"><input type="text" class="form-control" name="InputSessions" id="InputSessions" placeholder="Enter Sessions" value=""></div>

                            </div>
                            <div class="row">
                                <p></p>
                            </div>
                            <div class="row">
                              <div class="col-sm-2">Days</div>
                              <div class="col-sm-2"></div>
                              <div class="col-sm-2"></div>
                              <div class="col-sm-2"></div>
                              <div class="col-sm-2">Start Time</div>
                              <div class="col-sm-2">End Time</div>
                            </div>
                            <div class="row" >



                                <div class="col-sm-2">

                                  <div class="checkbox">
                                    <label><input type="checkbox" name="class_day[]" value="Mon">Mon</label>
                                  </div>
                                  <div class="checkbox">
                                    <label><input type="checkbox" name="class_day[]" value="Tues">Tue</label>
                                  </div>
                                </div>
                                <div class="col-sm-2">
                                  <div class="checkbox">
                                    <label><input type="checkbox" name="class_day[]" value="Wed">Wed</label>
                                  </div>
                                  <div class="checkbox">
                                    <label><input type="checkbox" name="class_day[]" value="Thur">Thu</label>
                                  </div>
                                </div>
                                <div class="col-sm-2">
                                  <div class="checkbox">
                                    <label><input type="checkbox" name="class_day[]" value="Fri">Fri</label>
                                  </div>
                                  <div class="checkbox">
                                    <label><input type="checkbox" name="class_day[]" value="Sat">Sat</label>
                                  </div>
                                </div>
                                 <div class="col-sm-2">
                                  <div class="checkbox">
                                    <label><input type="checkbox" name="class_day[]" value="Sun">Sun</label>
                                  </div>
                                </div>

                                  <div class="col-sm-2">
                                  <div class='input-group date' id='datetimepicker3'>
                                    <input type='text' class="form-control" name="InputStartTime" id="InputStartTime"/>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                  </div>
                                </div>
                                 <script type="text/javascript">
                                    $(function () {
                                        $('#datetimepicker3').datetimepicker({
                                            format: 'LT'
                                        });
                                    });
                                </script>
                                <div class="col-sm-2">
                                  <div class='input-group date' id='datetimepicker4'>
                                    <input type='text' class="form-control" name="InputEndTime" id="InputEndTime"/>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                  </div>
                                </div>
                                 <script type="text/javascript">
                                    $(function () {
                                        $('#datetimepicker4').datetimepicker({
                                            format: 'LT'
                                        });
                                    });
                                </script>


                            </div>
                            <div class="row" ><p></p></div>
                      </div>

                  </div>
                   <div class="panel-footer">
                      <div class="row">
                          <div class="col-sm-10">

                          </div>
                           <div class="col-sm-2">
                            <button type="button" id="btnAddLocationClass" class="btn btn-primary btn-sm btn-block">
                                Add Class</button>
                            </div>
                      </div>
                  </div>
               </div>

            </div>


        <hr />
        <div id="div1">


        </div>
           <!-- <div id="map-canvas"></div>-->

            <!-- create team code-->




        </form>

    </div>
</div>