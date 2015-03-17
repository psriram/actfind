
<div class="panel panel-default">
                  <div class="panel-heading">
                      <h3 class="panel-title">
                          <span class="fa fa-question-circle"></span> Session Setup</h3>
                  </div>
                  <div class="panel-body two-col">
                        <div class="form-group" id='classBoxesGroup'>
                            <div class="row">
                              <div class="col-sm-2">Session Name</div>
                              <div class="col-sm-2">#Sessions</div>
                              <div class="col-sm-2">Session Start Date</div>
                              <div class="col-sm-2">Session End Date</div>

                            </div>
                            <div class="row" >

                                <div class="col-sm-2"><input type="text" class="form-control" name="InputSessionName" id="InputSessionName" placeholder="Enter Session Name" value=""></div>
                                <div class="col-sm-2"><input type="text" class="form-control" name="InputSessions" id="InputSessions" placeholder="Enter # of Sessions" value=""></div>
                                <div class="col-sm-2">
                                  <div class='input-group date' id='sessiondatetimepicker1'>
                                    <input type='text' class="form-control" name="InputSessionStartDate" id="InputSessionStartDate"/>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                  </div>
                                </div>
                                 <script type="text/javascript">
                                    $(function () {
                                        $('#sessiondatetimepicker1').datetimepicker({
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

?>