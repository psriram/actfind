<?php

  try {
      if (isset($_SESSION['user']['id'])) {


        $Models_General = new Models_General();


        $arr = array();
       // $arr['Club_Location_Id'] = !empty($_GET['location_id']) ? $_GET['location_id'] : '';
        $arr['club_class_id'] = !empty($_GET['club_class_id']) ? $_GET['club_class_id'] : '';
        $arr['Class_Session_Id'] = !empty($_GET['club_session_id']) ? $_GET['club_session_id'] : '';
        $start_time = !empty($_POST['InputStartTime']) ? $_POST['InputStartTime'] : '';
        //$arr['Class_Start_Time'] = date('H:i:s', $start_time);
        $arr['Class_Start_Time'] = date('H:i:s', strtotime( $start_time)) ;
        $end_time = !empty($_POST['InputEndTime']) ? $_POST['InputEndTime'] : '';
        //$arr['Class_End_Time'] = date('H:i:s', $end_time);
        $arr['Class_End_Time'] = date('H:i:s', strtotime( $end_time)) ;
        $arr['Classes'] = !empty($_POST['InputClasses']) ? $_POST['InputClasses'] : '';
        $arr['Updated_Date'] = date('Y-m-d H:i:s');
        $class_day = !empty($_POST['class_day']) ? $_POST['class_day'] : array();

        //pr($_POST['class_day']);
        //exit;
        if (!empty($class_day)) {

           foreach ($class_day as $v) {
              $arr['Class_Day']  = $v;
              //pr($arr);
              //exit;
              $Models_General->addDetails('class_schedule', $arr);
            }
        }

         $return = array('success' => 1, 'msg' => 'added schedule');
         echo json_encode($return);
         exit;
         //header("Location: /activityfinder/prototype/clubs/location_setup");

      }
      else{
        header("Location: /activityfinder/prototype/users/register?action=signup&callback=register");
      }

  }
  catch (Exception $e) {
      $return = array('success' => 0, 'msg' => $e->getMessage());
      echo json_encode($return);
      exit;

  }?>