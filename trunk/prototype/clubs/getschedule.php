<?php


  try {
      $model = new Models_General();
      $schedule_id = $_GET['schedule_id'];

      $query = "SELECT cs.*,ch.*,cls.* FROM club_session_setup cs join class_schedule ch on cs.class_session_id=ch.class_session_id ";
      $query = $query. " join club_class cls on cls.club_class_id=ch.club_class_id WHERE ch.class_schedule_id=?";
      $query = $query. " ORDER BY ch.Created_Date DESC";
     // echo($query);
     // exit;
      $result_row = $model->fetchRow($query, array($schedule_id), 0);
      //pr($result_row);
      //exit;
      if (empty($result_row )) {
        $return = array('success' => 0, 'msg' => 'No Schedule found');
      }
      else{
        $return = array(
                  "class_id" => $result_row['club_class_Id'],
                  "class_name" => $result_row['class_name'],
                  "start_age" => $result_row['Start_Age'],
                  "end_age" => $result_row['End_Age'],
                  "start_date" => $result_row['Start_Date'],
                  "end_date" => $result_row['End_Date'],
                  "Classes" => $result_row['Classes'],
                  "class_day" => $result_row['Class_Day'],
                  //"class_start_time" => $result_row['Class_Start_Time'],
                  "class_start_time" => date('g:i:s', strtotime( $result_row['Class_Start_Time'])),
                  //"class_end_time" => $result_row['Class_End_Time'],
                  "class_end_time" => date('g:i:s', strtotime( $result_row['Class_End_Time'])),
                  "class_schedule_id" => $result_row['Class_Schedule_Id'],
                  "class_session_id" => $result_row['Class_Session_Id'],
                  "session_name" => $result_row['Session_Name']
            );

      }
  }
  catch (Exception $e) {
        $return = array('success' => 0, 'msg' => $e->getMessage());

  }
  echo json_encode($return);
  exit;

?>