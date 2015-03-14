<?php

  try {
      if (isset($_SESSION['user']['id'])) {


        $Models_General = new Models_General();



        $arr = array();
        //$arr['Club_Location_Id'] = $_SESSION['club_location_id'];

        $arr['Club_Location_Id'] = !empty($_POST['hdnLocation']) ? $_POST['hdnLocation'] : '';
        $arr['Class_Name'] = !empty($_POST['InputClass']) ? $_POST['InputClass'] : '';
        $arr['Start_Age'] = !empty($_POST['InputStartAge']) ? $_POST['InputStartAge'] : '';
        $arr['End_Age'] = !empty($_POST['InputEndAge']) ? $_POST['InputEndAge'] : '';
        $start_date = !empty($_POST['InputStartDate']) ? $_POST['InputStartDate'] : '';
        $arr['Start_Date'] = "'".date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $start_date)))."'";
        $end_date = !empty($_POST['InputEndDate']) ? $_POST['InputEndDate'] : '';
        $arr['End_Date'] = "'".date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $end_date)))."'";
        $arr['Sessions'] = !empty($_POST['InputSessions']) ? $_POST['InputSessions'] : '';
        $arr['updated_date'] = date('Y-m-d H:i:s');

        $id=$Models_General->addDetails('Class_Setup', $arr);
        $_SESSION['class_id'] = $id;

        $arr = array();
        $arr['Class_Id'] = $_SESSION['class_id'];
        $arr['Club_Location_id'] = !empty($_POST['hdnLocation']) ? $_POST['hdnLocation'] : '';
        $start_time = !empty($_POST['InputStartTime']) ? $_POST['InputStartTime'] : '';
        $arr['Class_Start_Time'] = date('H:i:s', $start_time);
        $end_time = !empty($_POST['InputEndTime']) ? $_POST['InputEndTime'] : '';
        $arr['Class_End_Time'] = date('H:i:s', $end_time);
        $arr['Updated_Date'] = date('Y-m-d H:i:s');
        $class_day = !empty($_POST['class_day']) ? $_POST['class_day'] : array();
        if (!empty($class_day)) {

           foreach ($class_day as $v) {
              $arr['Class_Day']  = $v;

              $Models_General->addDetails('Class_Schedule', $arr);
            }
        }
         // $return = array('success' => 1, 'msg' => '');

         //echo json_encode($return);
         //exit;
         //header("Location: /activityfinder/prototype/clubs/location_setup");
         if (!empty($_POST['hdnLocation'])) {
            $club_location_id = $_POST['hdnLocation'];
          }
          $query = "SELECT cs.*,ch.* FROM class_setup cs join class_schedule ch on cs.class_id=ch.class_id and cs.club_location_id=ch.club_location_id WHERE ch.Club_Location_Id = ? ORDER BY ch.Created_Date DESC";

          //exit;
          $resultModuleFields = $Models_General->fetchAll($query, array($club_location_id), 0);

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
        <h2>Schedule for Location <?php echo $_POST['lockeywords']; ?> </h2>

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
            //echo($v['Class_Day']);
        ?>


            <tr>
              <td><?php echo $v['Class_Name']; ?></td>
              <td><?php echo $v['Start_Age']; ?></td>
              <td><?php echo $v['End_Age']; ?></td>
              <td><?php echo $v['Start_Date']; ?></td>
              <td><?php echo $v['End_Date']; ?></td>
               <td><?php echo $v['Sessions']; ?></td>
              <td><?php echo $v['Class_Day']; ?></td>
              <td><?php echo $v['Class_Start_Time']; ?></td>
              <td><?php echo $v['Class_End_Time']; ?></td>
              <td><button type="button" id="<?php echo $btnId; ?>" class="btn btn-primary btn-sm btn-block" onclick="copySchedule('<?php echo $v['Class_Schedule_Id']; ?>')">
              Copy Schedule</button></td>
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
      else{
        header("Location: /activityfinder/prototype/users/register?action=signup&callback=register");
      }

  }
  catch (Exception $e) {
      $return = array('success' => 0, 'msg' => $e->getMessage());
      echo json_encode($return);
      exit;

  }?>