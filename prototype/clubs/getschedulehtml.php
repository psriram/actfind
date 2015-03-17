<?php



  $model = new Models_General();
  $params['where'] = " and Club_Location_Id=".$model->qstr($_GET['club_location_id']);
  $clubSessions = $model->getDetails('club_session_setup',$params);
  //pr($clubSessions);
 //exit;

  $params['where'] = " and Club_Id=".$model->qstr($_SESSION['club_id']);
  $clubClasses = $model->getDetails('club_class',$params);


?>
<script src="js/schedule.js" type="text/javascript"></script>
<div class="panel panel-default">
                  <div class="panel-heading">
                      <h3 class="panel-title">
                          <span class="fa fa-question-circle"></span> Schedule Setup</h3>
                  </div>
                  <div class="panel-body two-col">
                        <div class="form-group" id='classBoxesGroup'>



                            <div class="row">
                              <div class="col-sm-4">Class Name</div>
                              <div class="col-sm-4">Session Name</div>
                              <div class="col-sm-4">#Classes</div>
                            </div>
                            <div class="row" >
                                <!--<div class="col-sm-2"><input type="text" class="form-control" name="InputClass" id="InputClass" placeholder="Enter Class Name" value=""></div>-->
                                <div class="col-sm-4">

                                     <?php if (!empty($clubClasses)) { ?>
                                    <div class="dropdown">
                                         <input
                                                    id="classKeywords"
                                                    class="dropdown-toggle"
                                                    data-toggle="dropdown"
                                                    type="text"
                                                    name="classkeywords"
                                                    size="20"
                                                    maxlength="20"
                                                    value=""
                                                    placeholder="Select Class"
                                                    autocomplete="off"
                                                    />

                                         <ul class="dropdown-menu" id="sltClubClass">
                                        <?php
                                          foreach ($clubClasses as $v) {
                                            ?>

                                              <li role="presentation"><a role="menuitem" href="javascript:;" data-value="<?php echo $v['club_class_id']; ?>" data-copy="<?php echo $v['club_class_id']; ?>">
                                              <?php echo $v['class_name']; ?>
                                              </a></li>

                                          <?php
                                          }?>
                                           </ul>
                                           <input type="hidden" id="hdnClass" name="hdnClass" value=""/>
                                    </div>

                                        <?php
                                        }
                                      ?>
                                </div>


                                <!--<div class="col-sm-2"><input type="text" class="form-control" name="InputClass" id="InputClass" placeholder="Enter Class Name" value=""></div>-->
                                <div class="col-sm-4">

                                     <?php if (!empty($clubSessions)) { ?>
                                    <div class="dropdown">
                                         <input
                                                    id="sessionKeywords"
                                                    class="dropdown-toggle"
                                                    data-toggle="dropdown"
                                                    type="text"
                                                    name="sessionkeywords"
                                                    size="20"
                                                    maxlength="20"
                                                    value=""
                                                    placeholder="Select Session"
                                                    autocomplete="off"
                                                    />

                                         <ul class="dropdown-menu" id="sltClubSession">
                                        <?php
                                          foreach ($clubSessions as $v) {
                                            ?>

                                              <li role="presentation"><a role="menuitem" href="javascript:;" data-value="<?php echo $v['Class_Session_Id']; ?>" data-copy="<?php echo $v['Class_Session_Id']; ?>">
                                              <?php echo $v['Session_Name']; ?>
                                              </a></li>

                                          <?php
                                          }?>
                                           </ul>
                                           <input type="hidden" id="hdnSession" name="hdnSession" value=""/>
                                    </div>

                                        <?php
                                        }
                                      ?>
                                </div>

                                <div class="col-sm-4"><input type="text" class="form-control" name="InputClasses" id="InputClasses" placeholder="Enter Classes" value=""></div>

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
  <?php
  exit;
  ?>