<?php

  try {
      if (isset($_SESSION['user']['id'])) {


        $Models_General = new Models_General();

        //pr($_POST);
        //exit;

        $arr = array();
        //$arr['Club_Location_Id'] = $_SESSION['club_location_id'];
        $arr['club_location_id'] = !empty($_GET['location_id']) ? $_GET['location_id'] : '';
        $arr['club_schedule_id'] = !empty($_GET['schedule_id']) ? $_GET['schedule_id'] : '';
        $arr['session_name'] = !empty($_POST['InputSessionName']) ? $_POST['InputSessionName'] : '';
        $start_date = !empty($_POST['InputStartDate']) ? $_POST['InputStartDate'] : '';
        $arr['start_date'] = "'".date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $start_date)))."'";
        $end_date = !empty($_POST['InputEndDate']) ? $_POST['InputEndDate'] : '';
        $arr['end_date'] = "'".date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $end_date)))."'";

        $arr['updated_date'] = date('Y-m-d H:i:s');

        $id=$Models_General->addDetails('club_session_setup', $arr);

        $return = array('success' => 1, 'msg' => 'added session');
         echo json_encode($return);
         exit;

         //header("Location: /actfind/prototype/clubs/location_setup");

      }
      else{
        header("Location: /actfind/prototype/users/register?action=signup&callback=register");
      }

  }
  catch (Exception $e) {
      $return = array('success' => 0, 'msg' => $e->getMessage());
      echo json_encode($return);
      exit;

  }?>