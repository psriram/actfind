<?php


  try {
      $model = new Models_General();
      $schedule_id = $_REQUEST['schedule_id'];

      $query = "SELECT cs.*,ch.*,cls.class_name FROM class_setup cs join class_schedule ch on cs.class_id=ch.class_id join club_class cls on cls.club_classid=cs.club_classid  WHERE ch.Class_Schedule_id = ? ";

      $result_row = $model->fetchRow($query, array($schedule_id), 0);
      //pr($result_row);
      //exit;
      if (empty($result_row )) {
        $return = array('success' => 0, 'msg' => 'No Schedule found');
      }
      else{
        $return = array(
                  "class_id" => $result_row['Class_Id'],
                  "class_name" => $result_row['class_name'],
                  "start_age" => $result_row['Start_Age'],
                  "end_age" => $result_row['End_Age'],
                  "start_date" => $result_row['Start_Date'],
                  "end_date" => $result_row['End_Date'],
                  "sessions" => $result_row['Sessions'],
                  "class_day" => $result_row['Class_Day'],
                  "class_start_time" => $result_row['Class_Start_Time'],
                  "class_end_time" => $result_row['Class_End_Time'],
                  "class_schedule_id" => $result_row['Class_Schedule_Id'],
            );

      }
  }
  catch (Exception $e) {
        $return = array('success' => 0, 'msg' => $e->getMessage());

  }
  echo json_encode($return);
  exit;

?>