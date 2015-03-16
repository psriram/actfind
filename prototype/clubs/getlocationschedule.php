<?php


  try {
      $model = new Models_General();
      $club_location_id = $_REQUEST['club_location_id'];

      $query = "SELECT cs.*,ch.*,cls.class_name FROM class_setup cs join class_schedule ch on cs.class_id=ch.class_id and cs.club_location_id=ch.club_location_id join club_class cls on cls.club_classid=cs.club_classid WHERE ch.Club_Location_Id = ? ORDER BY ch.Created_Date DESC";
      //echo($query);
      //echo($club_location_id);
      $resultModuleFields = $model->fetchAll($query, array($club_location_id), 0);
       //pr($resultModuleFields);
         // exit;
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
              <th>#Sessions</th>
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
            //echo($v['Class_Day']);
        ?>


            <tr>
              <td><?php echo $v['class_name']; ?></td>
              <td><?php echo $v['Start_Age']; ?></td>
              <td><?php echo $v['End_Age']; ?></td>
              <td><?php echo $v['Start_Date']; ?></td>
              <td><?php echo $v['End_Date']; ?></td>
               <td><?php echo $v['Sessions']; ?></td>
              <td><?php echo $v['Class_Day']; ?></td>
              <td><?php echo $v['Class_Start_Time']; ?></td>
              <td><?php echo $v['Class_End_Time']; ?></td>
              <td><button type="button" id="<?php echo $btnId; ?>" class="btn btn-primary btn-sm btn-block" onclick="copySchedule('<?php echo $v['Class_Schedule_Id']; ?>')">
              Copy</button></td>
             <!-- <td><button type="button" id="<?php echo $btnEdit; ?>" class="btn btn-primary btn-sm btn-block" onclick="editSchedule('<?php echo $v['Class_Schedule_Id']; ?>')">
              Edit</button></td>-->
              <td><button type="button" id="<?php echo $btnDelete; ?>" class="btn btn-primary btn-sm btn-block" onclick="deleteSchedule('<?php echo $v['Class_Id']; ?>')">
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