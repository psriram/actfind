$( document ).ready(function() {

	$('#sltClubClass li a').on('click', function(){

      var selectedOption = $(this).attr('data-value');
      var class_name = $(this).text().trim();
      //alert(selectedOption);
      //alert(class_name);
      $('#classKeywords').val($(this).text().trim());
      $('#hdnClass').val(selectedOption);


    });

    $('#sltClubSession li a').on('click', function(){
      //alert(this);
      var selectedOption = $(this).attr('data-value');
      var class_name = $(this).text().trim();
      //alert(selectedOption);
      //alert(selectedOption);
      $('#sessionKeywords').val($(this).text().trim());
      $('#hdnSession').val(selectedOption);


    });

    $('#btnAddLocationClass').on('click', function(){
        /*var location_val = $("#locKeywords").val().trim();
        if(location_val==""){
          alert("Please select location");
          $("#locKeywords").focus();
          return false;
        }*/
        //var location_id = $("#hdnLocation").val();
        var class_id = $("#hdnClass").val();
        var session_id = $('#hdnSession').val();
        //alert(location_id);

        $.ajax({

                url: "/actfind/prototype/clubs/saveschedule?club_class_id="+class_id+'&club_session_id='+session_id,
                type: "post",
                data: $("#formSchedule").serialize(),
                success: function(d) {
                    //alert(d);
                    var location_id = $("#hdnLocation").val();
                    var session_id =  $('#hdnSession').val();
                    //alert(location_id);
                    var location_name = $('#locKeywords').val();
                    var data = {club_location_id : location_id,location_name:location_name,session_id:session_id}
                    $.ajax({
                        url: "/actfind/prototype/clubs/getlocationschedule",
                        type: "GET",
                        data: data,
                        success: function(d) {
                          $('#div1').html(d);
                        }
                    });

                }
            });

    });

 });