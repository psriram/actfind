<?php
  $layoutFile = 'layouts/home/templateLeague';
  $pageTitle = 'Login Details';

?>

 <style>
    .red {
      color: red;
    }
</style>
<script type="text/javascript">
      // Enter a client ID for a web application from the Google Developer Console.
      // The provided clientId will only work if the sample is run directly from
      // https://google-api-javascript-client.googlecode.com/hg/samples/authSample.html
      // In your Developer Console project, add a JavaScript origin that corresponds to the domain
      // where you will be running the script.
      //var clientId = '787762404006-0p0grihel4hgv14bu5lbhcjpgiio5t5a.apps.googleusercontent.com';
      var clientId = '437724595536-5ra6e0p4lfqre9m9q70cu0knpfbkcr1m.apps.googleusercontent.com';
      // Enter the API key from the Google Develoepr Console - to handle any unauthenticated
      // requests in the code.
      // The provided key works for this sample only when run from
      // https://google-api-javascript-client.googlecode.com/hg/samples/authSample.html
      // To use in your own application, replace this API key with your own.
      //var apiKey = 'AIzaSyCAPTSi4Q8q0bhcX2Wc6UtAWVjh2OKNJMY';
      var apiKey = 'AIzaSyBvXqWIcqyTVRgjXsVjDbdORcNaXHVjtOw';

      // To enter one or more authentication scopes, refer to the documentation for the API.
      var scopes = 'https://www.googleapis.com/auth/plus.me';

      // Use a button to handle authentication the first time.
      function handleClientLoad() {
        gapi.client.setApiKey(apiKey);
        window.setTimeout(checkAuth,1);
      }

      function checkAuth() {
        gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: true}, handleAuthResult);
      }


      function handleAuthResult(authResult) {
        var authorizeButton = document.getElementById('authorize-button');
        if (authResult && !authResult.error) {
          authorizeButton.style.visibility = 'hidden';
          makeApiCall();
        } else {
          authorizeButton.style.visibility = '';
          authorizeButton.onclick = handleAuthClick;
        }
      }

      function handleAuthClick(event) {
        gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: false}, handleAuthResult);
        return false;
      }

      // Load the API and make an API call.  Display the results on the screen.
      function makeApiCall() {

        gapi.client.load('plus', 'v1', function() {
          var request = gapi.client.plus.people.get({
            'userId': 'me'
          });
          request.execute(function(resp) {
            //console.log(resp);
            var heading = document.createElement('h4');
            var image = document.createElement('img');
            image.src = resp.image.url;
            heading.appendChild(image);
            heading.appendChild(document.createTextNode(resp.displayName));

            //$.post( "/prototype/users/saveuser", resp);
            $.post( "/activityfinder/prototype/users/saveuser",resp)
              .done(function( data ) {
                //alert( "Data Loaded: " + data );
                //location.href="/";
              });
            //document.getElementById('content').appendChild(heading);
          });
        });
      }
      $( document ).ready(function() {
          $('#btnSignIn2').on('click', function(){

            //alert($(this).text());
            var email_val = $("#txtEmail").val().trim();
            var name_val = $("#txtName").val().trim();

            //return false;
            var passwd = $("#txtPassword").val().trim();

            if(email_val=="" || passwd === ""){
              $("#divError").html( "<span class='red'>Please enter email and password</span>" );
              //alert("please enter email and passwd");
              return false;
            }
            /*$.post( "/prototype/users/savepasswd", function( data ) {
              alert( "Data Loaded: " + data );
            });*/

            //alert(email_val);
            //alert(passwd);
           var resp = { email: email_val, password: passwd, name: name_val,action:"signup",type: "self" };

           //console.log(resp);
           $.post( "/activityfinder/prototype/users/saveuser",resp)
              .done(function( data ) {
                var obj = JSON.parse(data);
                alert(obj.msg);
                console.log(obj.success);
                console.log(obj.msg);
                if(obj.success=="0"){
                  $("#divError").html( "<span class='red'>"+obj.msg+"</span>" );
                  return false;
                }
                else{
                   location.href="/";
                }
                //location.href="/";
              },"json");
            return false;

          });

           $('#btnLogIn').on('click', function(){
            //alert("here");
            //alert($(this).text());
            var email_val = $("#txtEmail").val().trim();
            var passwd = $("#txtPassword").val().trim();
            if(email_val=="" || passwd == ""){
               $("#divError").html( "<span class='red'>Please enter email and password</span>" );
              //alert("here");
              return false;
            }
            /*$.post( "/prototype/users/savepasswd", function( data ) {
              alert( "Data Loaded: " + data );
            });*/

            //alert(email_val);
            //alert(passwd);
           var resp = { email: email_val, password: passwd, action:"login",type: "self" };
           //console.log(resp);
           $.post( "/activityfinder/prototype/users/saveuser",resp)
              .done(function( data ) {
                var obj = JSON.parse(data);
                //console.log(data);
                console.log(obj.success);
                console.log(obj.msg);
                if(obj.success=="0"){
                  $("#divError").html( "<span class='red'>"+obj.msg+"</span>" );
                  return false;
                }
                else{
                  location.href="/";
                }
              },"json");
            return false;

          });
      });
</script>
<script src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script>


<div  class="col-md-4"></div>
<form class="col-md-4" method="POST" action="" name="form1" id="form1">

    <div class="row text-center">
     <p></p>
    </div>
     <div class="row text-center">
     <p></p>
    </div>
    <div class="row text-center">
        <div class="col-md-4 col-sm-4">
            <button type="button" class="btn btn-primary btn-block">Facebook</button>
        </div>

        <div class="col-md-4 col-sm-4">
          <button type="button" id="authorize-button" class="btn btn-danger btn-block" style="visibility: hidden">Google+</button>
        </div>
    </div>
    <hr />
    <div id="divError" class="row text-center">

    </div>
    <div class="form-group">
        <input id="txtEmail" type="text" class="form-control input-lg" placeholder="Email">
    </div>
    <div class="form-group">
        <input id="txtPassword" type="password" class="form-control input-lg" placeholder="">
    </div>
    <div class="form-group">
        <?php if ($_REQUEST['action']=="signup") { ?>
            <input id="txtName" type="text" class="form-control input-lg" placeholder="Name">
        <?php } ?>
    </div>
    <div class="form-group">
       <?php if ($_REQUEST['action']=="signin") { ?>
            <button id="btnLogIn" class="btn btn-primary btn-lg btn-block">Log In</button>
        <?php } else { ?>
            <button id="btnSignIn2" class="btn btn-primary btn-lg btn-block">Sign Up</button>
        <?php } ?>
    </div>

</form>
