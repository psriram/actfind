<?php

  try {
      if (isset($_SESSION['user']['id'])) {


        $Models_General = new Models_General();
       // $model = new Models_ActivityFinder();
        //echo("here");
       // exit;
            //$categoryDisplay = $model->category();

        $arr = array();

       // $arr['club_id'] = guid();
        $arr['user_id'] = $_SESSION['user']['id'];
        $arr['name'] = !empty($_POST['InputName']) ? $_POST['InputName'] : '';
        $arr['email'] = $_SESSION['user']['email'];;
        $arr['website'] = !empty($_POST['InputWebsite']) ? $_POST['InputWebsite'] : '';
        $arr['password'] = !empty($_POST['InputPassword']) ? $_POST['InputPassword'] : '';
        $arr['lat'] = !empty($_POST['lat']) ? $_POST['lat'] : '';
        $arr['lon'] = !empty($_POST['lng']) ? $_POST['lng'] : '';
        $arr['details'] = !empty($_POST['InputDetails']) ? $_POST['InputDetails'] : '';
        $arr['address'] = !empty($_POST['InputLocation']) ? $_POST['InputLocation'] : '';
        $arr['updated_date'] = date('Y-m-d H:i:s');
        $arr['phone_number'] = !empty($_POST['InputPhone']) ? $_POST['InputPhone'] : '';
        //$arr['status'] = 1;

        $id=$Models_General->addDetails('Club', $arr, $_SESSION['user']['user_id']);


        $category = !empty($_POST['category']) ? $_POST['category'] : array();

        if (!empty($category)) {
            $cats = array();
            $cats['club_id'] = $id;
            foreach ($category as $v) {
              $cats['category_id'] = $v;
              $Models_General->addDetails('Club_Category', $cats);
            }
        }

        if (empty($id)){
          header("Location: /activityfinder/prototype/clubs/join&error=1");
        }
        else{
          $_SESSION['club_id'] = $id;
          header("Location: /activityfinder/prototype/clubs/location_setup");
        }
           // echo json_encode($return);
           // exit;
      }
      else{
        header("Location: /activityfinder/prototype/users/register?action=signup&callback=register");
      }

  }
  catch (Exception $e) {
      $return = array('success' => 0, 'msg' => $e->getMessage());

  }



?>