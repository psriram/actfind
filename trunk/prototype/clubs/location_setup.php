<?php


  $layoutFile = 'layouts/home/templateClub';
  $pageTitle = 'Join a club';
  $model = new Models_General();
  $params['where'] = " and Club_Id=".$model->qstr($_SESSION['club_id']);
  $clubLocations = $model->getDetails('club_location',$params);

  //$params['where'] = " and Club_Id=".$model->qstr($_SESSION['club_id']);
  //$clubClasses = $model->getDetails('club_class',$params);
  //pr($clubClasses);
  //exit;
  $params['where'] = " and Club_Id=".$model->qstr($_SESSION['club_id']);
  $clubScheduleSetup = $model->getDetails('club_schedule_type',$params);



?>

<script type="text/javascript">

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
                                    autocomplete="off"
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

             <div class="form-group">

                     <?php if (!empty($clubScheduleSetup)) { ?>
                    <div class="dropdown">
                         <input
                                    id="setupKeywords"
                                    class="dropdown-toggle"
                                    data-toggle="dropdown"
                                    type="text"
                                    name="setupkeywords"
                                    size="50"
                                    maxlength="100"
                                    value=""
                                    placeholder="Select Schedule"
                                    autocomplete="off"
                                    />

                         <ul class="dropdown-menu" id="sltScheduleSetup">
                        <?php
                          foreach ($clubScheduleSetup as $v) {
                            ?>

                              <li role="presentation"><a role="menuitem" href="javascript:;" data-value="<?php echo $v['club_schedule_id']; ?>" data-copy="<?php echo $v['club_schedule_id']; ?>">
                              <?php echo $v['schedule_name']; ?>
                              </a></li>

                          <?php
                          }?>
                           </ul>
                           <input type="hidden" id="hdnScheduleSetup" name="hdnScheduleSetup" value=""/>
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
                          <span class="fa fa-question-circle"></span> Session Setup</h3>
                  </div>
                  <div class="panel-body two-col">
                        <div class="form-group" id='classBoxesGroup'>
                            <div class="row">
                              <div class="col-sm-2">Session Name</div>
                              <div class="col-sm-2">Session Start Date</div>
                              <div class="col-sm-2">Session End Date</div>

                            </div>
                            <div class="row" >

                                <div class="col-sm-2"><input type="text" class="form-control" name="InputSessionName" id="InputSessionName" placeholder="Enter Session Name" value=""></div>

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




                            </div>

                      </div>

                  </div>
                   <div class="panel-footer">
                      <div class="row">
                          <div class="col-sm-10">

                          </div>
                           <div class="col-sm-2">
                            <button type="button" id="btnAddSession" class="btn btn-primary btn-sm btn-block">
                                Add Session</button>

                           </div>
                  </div>
               </div>

            </div>

         <hr />


        <div id="divschedule">


        </div>

        <div id="div1">


        </div>


         <input type="hidden" id="hdnClassId" name="hdnClassId" value=""/>
         <input type="hidden" id="hdnClassScheduleId" name="hdnClassScheduleId" value=""/>
        </form>

    </div>
</div>
</div>