function copySchedule(class_schedule_id){
  //alert(class_schedule_id);

    //$("#btnUpdateLocationClass").hide();
    //var data = 'schedule_id='+ class_schedule_id

    var location_id = $("#hdnLocation").val();
                    //alert(location_id);
    var location_name = $('#locKeywords').val();
    var data = {club_location_id : location_id,location_name:location_name}
    $.ajax({
        url: "/activityfinder/prototype/clubs/getschedulehtml",
        type: "GET",
        data: data,
        success: function(d) {
          $('#divschedule').html(d);
          var data = {schedule_id : class_schedule_id};

          $.ajax({
                url: "/activityfinder/prototype/clubs/getschedule",
                type: "GET",
                data: data,
                success: function(d) {
                    //alert("here");
                    var obj = JSON.parse(d);
                    //console.log(obj);
                    $('#classKeywords').val(obj.class_name);
                    $('#sessionKeywords').val(obj.session_name);
                    $('#InputClasses').val(obj.Classes);
                    $('#InputStartTime').val(obj.class_start_time);
                    $('#InputEndTime').val(obj.class_end_time);

                    var inputs = document.getElementsByTagName("input");
                    for(var i = 0; i < inputs.length; i++){
                      if(inputs[i].type == "checkbox"){
                        if(inputs[i].value==obj.class_day){
                          inputs[i].checked = true;
                        }
                        else{
                          inputs[i].checked = false;
                        }
                      }
                    }
                    $("#classKeywords").focus();
                    /*for(var i=0; i < document.formSchedule.class_day[].length; i++){
                      if(document.formSchedule.class_day[i].value==d.class_day){
                         document.formSchedule.class_day[i].checked=true;
                      }
                    }*/
                    //console.log(obj);
                }
            });
        }
    });


}
function editSchedule(class_schedule_id){
    var data = {schedule_id : class_schedule_id};
    $("#btnAddLocationClass").hide();
    $("#btnUpdateLocationClass").show();
    //var data = 'schedule_id='+ class_schedule_id
     $.ajax({
                url: "/activityfinder/prototype/clubs/getschedule",
                type: "POST",
                data: data,
                success: function(d) {
                   //alert("here");
                    var obj = JSON.parse(d);

                    $('#classKeywords').val(obj.class_name);
                    $('#sessionkeywords').val(obj.session_name);
                    $('#InputClasses').val(obj.Classes);
                    $('#InputStartTime').val(obj.class_start_time);
                    $('#InputEndTime').val(obj.class_end_time);
                    $('#hdnClassScheduleId').val(obj.class_schedule_id);
                    var inputs = document.getElementsByTagName("input");
                    for(var i = 0; i < inputs.length; i++){
                      if(inputs[i].type == "checkbox"){
                        if(inputs[i].value==obj.class_day){
                          inputs[i].checked = true;
                        }
                      }
                    }
                    $("#classKeywords").focus();
                    /*for(var i=0; i < document.formSchedule.class_day[].length; i++){
                      if(document.formSchedule.class_day[i].value==d.class_day){
                         document.formSchedule.class_day[i].checked=true;
                      }
                    }*/
                    //console.log(obj);
                }
            });
}
function deleteSchedule(class_schedule_id){
    var data = {class_schedule_id: class_schedule_id}
    //var data = 'schedule_id='+ class_schedule_id
     $.ajax({
                url: "/activityfinder/prototype/clubs/deleteschedule",
                type: "POST",
                data: data,
                success: function(d) {

                  var location_id = $("#hdnLocation").val();
                  var location_name = $('#locKeywords').val();
                  var session_id =  $('#hdnSession').val();

                  var data = {club_location_id : location_id,location_name:location_name,session_id:session_id}
                  $.ajax({
                        url: "/activityfinder/prototype/clubs/getlocationschedule",
                        type: "GET",
                        data: data,
                        success: function(d) {
                          $('#div1').html(d);
                        }
                  });

                }
            });
}
 $( document ).ready(function() {
    var location_counter = 2;
    var class_counter = 2;
    var schedule_counter = 2;

      $('#btnFindLocation').on('click', function(){
          //$('#locfind').hide();
          $('#locationgroup').show();

      });
      $('#btnAddLocation').on('click', function(){
           var newTextBoxDiv1 = $(document.createElement('div')).attr({"class":"input-group locationField"})

           newTextBoxDiv1.after().html('</br><input type="text" name="autocomplete' + location_counter +
                '" id="autocomplete' + location_counter + '" placeholder=" Enter Location ' + location_counter + '" onFocus="geolocate()" class="form-control" value="">' +
                '<input type="hidden" id="hdnLat' + location_counter + '" name="hdnLat' + location_counter + '"/>' +
                '<input type="hidden" id="hdnLong' + location_counter + '" name="hdnLong' + location_counter + '"/>'
                );

           newTextBoxDiv1.appendTo("#locfindgroup");
           initialize('autocomplete' + location_counter,'hdnLat' + location_counter,'hdnLong' + location_counter);
           $('#locationCounter').val(location_counter);
           location_counter++;
      });

      $('#btnAddClass').on('click', function(){
           var newTextBoxDiv2 = $(document.createElement('div')).attr({"class":"row"})

           newTextBoxDiv2.after().html('</br><div class="col-sm-6"><input type="text" name="InputClass' + class_counter +
                '" id="InputClass' + class_counter + '" placeholder=" Enter Class/Team ' + class_counter + '" class="form-control" value=""></div>' +
                '<div class="col-sm-3"><input type="text" name="InputStartAge' + class_counter +
                '" id="InputStartAge' + class_counter + '" placeholder=" Enter Start Age ' + class_counter + '" class="form-control" value=""></div>' +
                '<div class="col-sm-3"><input type="text" name="InputEndAge' + class_counter +
                '" id="InputEndAge' + class_counter + '" placeholder=" Enter End Age ' + class_counter + '" class="form-control" value=""></div>'
            );
           newTextBoxDiv2.appendTo("#divClass");

           $('#classCounter').val(class_counter);
           class_counter++;
      });
      $('#btnAddSchedule').on('click', function(){
           var newTextBoxDiv2 = $(document.createElement('div')).attr({"class":"input-group scheduleField"})

           newTextBoxDiv2.after().html('</br><input type="text" name="InputSchedule' + schedule_counter +
                '" id="InputSchedule' + schedule_counter + '" placeholder=" Enter Schedule ' + schedule_counter + '" class="form-control" value="">'
            );
           newTextBoxDiv2.appendTo("#divSchedule");

           $('#scheduleCounter').val(schedule_counter);
           schedule_counter++;
      });
    $('#sltClubLocation li a').on('click', function(){

      //alert(this);
      var selectedOption = $(this).attr('data-value');
      var location_name = $(this).text().trim();
      //alert(selectedOption);
      //alert(selectedOption);
      $('#locKeywords').val($(this).text().trim());
      $('#hdnLocation').val(selectedOption);

      var data = {club_location_id : selectedOption,location_name:location_name};
    //var data = 'schedule_id='+ class_schedule_id
     $.ajax({
                url: "/activityfinder/prototype/clubs/getlocationschedule",
                type: "GET",
                data: data,
                success: function(d) {
                  $('#div1').html(d);
                }
            });
    });





    $('#sltScheduleSetup li a').on('click', function(){
      //alert(this);
      var selectedOption = $(this).attr('data-value');
      var schedule_name = $(this).text().trim();
      //alert(selectedOption);
      //alert(selectedOption);
      $('#setupKeywords').val($(this).text().trim());
      $('#hdnScheduleSetup').val(selectedOption);
      /*if(selectedOption == 1){
       $.ajax({
              url: "/activityfinder/prototype/clubs/getSessionSchedule",
              type: "GET",
              data: data,
              success: function(d) {
                $('#divSession').html(d);
              }
        });
      }*/
    });



    $('#btnAddSession').on('click', function(){
        var location_val = $("#locKeywords").val().trim();
        if(location_val==""){
          alert("Please select location");
          $("#locKeywords").focus();
          return false;
        }
        var location_id = $("#hdnLocation").val();
        //var class_id = $("#hdnClass").val();
        var schedule_id = $('#hdnScheduleSetup').val();
        //alert(location_id);
        //alert(schedule_id);
        $.ajax({

                url: "/activityfinder/prototype/clubs/saveclasssession?location_id="+location_id+'&schedule_id='+schedule_id,
                type: "post",
                data: $("#formSchedule").serialize(),
                success: function(d) {

                    var location_id = $("#hdnLocation").val();
                    //alert(location_id);
                    var location_name = $('#locKeywords').val();
                    var data = {club_location_id : location_id,location_name:location_name}
                    $.ajax({
                        url: "/activityfinder/prototype/clubs/getschedulehtml",
                        type: "GET",
                        data: data,
                        success: function(d) {
                          $('#divschedule').html(d);
                        }
                    });
                    //$('#div1').html(d);
                }
            });

    });

    $('#btnUpdateLocationClass').on('click', function(){
        var location_val = $("#locKeywords").val().trim();
        if(location_val==""){
          alert("Please select location");
          $("#locKeywords").focus();
          return false;
        }
        var class_id = $('#hdnClassId').val();
        var class_schedule_id = $('#hdnClassScheduleId').val();
        $.ajax({
                url: "/activityfinder/prototype/clubs/updateschedule?class_id="+class_id+'&class_schedule_id='+class_schedule_id,
                type: "post",
                data: $("#formSchedule").serialize(),
                success: function(d) {
                    var location_id = $("#hdnLocation").val();
                    var location_name = $('#locKeywords').val();
                    var data = {club_location_id : location_id,location_name:location_name}
                    $.ajax({
                        url: "/activityfinder/prototype/clubs/getlocationschedule",
                        type: "GET",
                        data: data,
                        success: function(d) {
                          $('#div1').html(d);
                        }
                    });
                    //$('#div1').html(d);
                }
            });

    });



 });