<?php


  try {
      $model = new Models_General();
      //$club_location_id = $model->qstr($_GET['club_location_id']);
      //$club_session_id = $model->qstr($_GET['session_id']);
      $club_location_id = $_GET['club_location_id'];
      $club_session_id = $_GET['session_id'];

      $query = "SELECT cs.*,ch.*,cls.* FROM club_session_setup cs join class_schedule ch on cs.class_session_id=ch.class_session_id ";
      $query = $query. " join club_class cls on cls.club_class_id=ch.club_class_id WHERE cs.Club_Location_Id = ? ";
      $query = $query. " ORDER BY ch.Created_Date DESC";
      //echo($query);
      //exit;
      //echo("club_session_id".$club_session_id);
      //echo("club_location_id".$club_location_id);
      //exit;
      $resultModuleFields = $model->fetchAll($query, array($club_location_id), 0);
       //pr($resultModuleFields);
          //exit;
          if (empty($resultModuleFields)) {
            echo "No schedule found";
            exit;
          }
          //pr($resultModuleFields);
          //$resultModuleFields2 = array();
        ?>
         <div class="container">
        <h2>Schedule for Location <?php echo $_REQUEST['location_name']; ?> </h2>

        <table class="table">
          <thead>
            <tr>
              <th>Class Name</th>
              <th>Class Start Age</th>
              <th>Class End Age</th>
              <th>Class Start Date</th>
              <th>Class End Date</th>
              <th>#Classes</th>
              <th>Class Day</th>
              <th>Class Start Time</th>
              <th>Class End Time</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
        <?php
          $row_counter=1;
          foreach ($resultModuleFields as $k => $v) {
            $btnId = "btnCopySchedule".$row_counter;
            $btnEdit = "btnEditSchedule".$row_counter;
            $btnDelete = "btnDeleteSchedule".$row_counter;
            $start_time=date('g:i:s', strtotime($v['Class_Start_Time']));
            $end_time=date('g:i:s', strtotime($v['Class_End_Time']));
            //echo($v['Class_Day']);
        ?>


            <tr>
              <td><?php echo $v['class_name']; ?></td>
              <td><?php echo $v['Start_Age']; ?></td>
              <td><?php echo $v['End_Age']; ?></td>
              <td><?php echo $v['Start_Date']; ?></td>
              <td><?php echo $v['End_Date']; ?></td>
               <td><?php echo $v['Classes']; ?></td>
              <td><?php echo $v['Class_Day']; ?></td>
              <td><?php echo $start_time ?></td>
              <td><?php echo $end_time ?></td>
              <td><button type="button" id="<?php echo $btnId; ?>" class="btn btn-primary btn-sm btn-block" onclick="copySchedule('<?php echo $v['Class_Schedule_Id']; ?>')">
              Copy</button></td>

              <td><button type="button" id="<?php echo $btnDelete; ?>" class="btn btn-primary btn-sm btn-block" onclick="deleteSchedule('<?php echo $v['Class_Schedule_Id']; ?>')">
              Delete</button></td>
            </tr>



    <?php
        $row_counter++;
      }
      ?>
       </tbody>
        </table>
      </div>
  <?php
    exit;
  }
  catch (Exception $e) {
        $return = array('success' => 0, 'msg' => $e->getMessage());
        echo json_encode($return);
        exit;

  }


?>