<iframe id="logoutframe" src="https://accounts.google.com/logout" style="display: none"></iframe>
<?php

  unset($_SESSION['user']);
  session_destroy();
  //header('Location: http://' . $_SERVER['HTTP_HOST']);
  //exit;
?>


