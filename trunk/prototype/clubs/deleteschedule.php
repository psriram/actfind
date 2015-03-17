<?php


  try {
      $model = new Models_General();
      //$class_id = $_REQUEST['class_id'];
      $schedule_id = $_POST['class_schedule_id'];
      //echo($schedule_id);
      //exit;
      $query = "Delete from class_schedule where class_schedule_id=?";
      $result_row = $model->deleteDetails($query, array($schedule_id), 0);

      //$query = "Delete from class_schedule where class_schedule_id=?";
      //$result_row = $model->deleteDetails($query, array($schedule_id), 0);


      $return = array('success' => 1, 'msg' => 'deleted schedule');
  }
  catch (Exception $e) {
        $return = array('success' => 0, 'msg' => $e->getMessage());

  }
  echo json_encode($return);
  exit;

?>