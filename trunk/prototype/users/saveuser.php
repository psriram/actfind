<?php

if($_REQUEST['type']=='self'){
  try {
      //pr($_REQUEST);
      //exit;
      $email = $_REQUEST['email'];
      //check the email
      $rec = check_email($email);
      if($_REQUEST['action']=='signup'){

            if (!empty($rec)) {
                  throw new Exception ('This email is already registered. Want to log in or reset your password?');
            }
            $passwd = $_REQUEST['password'];
            $type = $_REQUEST['type'];
            $name = $_REQUEST['name'];
            $encpasswd = encryptAES($passwd);


            $data['user_id'] = guid();
            $data['email'] = $email;
            $data['password'] = $encpasswd;
            $data['name'] = $name;
            $data['sn_type'] = 'email';
            $model = new Models_General();
            $model->addDetails('auth', $data);

            $user = array(
                  "id" => $data['user_id'],
                  "email" => $data['email'],
                  "name" => $name,
                  "given_name" => $name,
                  "family_name" => $name
            );

            $_SESSION['user'] = $user;

            $return = array('success' => 1, 'msg' => '');
           // echo json_encode($return);
           // exit;
      }
      if($_REQUEST['action']=='login'){
            if (empty($rec)) {
                  throw new Exception ('Email does not exist in our Records,please try again or signup for new Account');
            }
             $email = $_REQUEST['email'];
             $passwd = $_REQUEST['password'];
             $type = $_REQUEST['type'];
             $encpasswd = encryptAES($passwd);

            $model = new Models_General();
            $params['where'] = " and email=  ".$model->qstr($email) . " and password= ". $model->qstr($encpasswd);
            $rec1 = $model->getDetails('auth',$params);
            $rec1 = $rec1[0];

            if (!empty($rec1)) {
                  $return = array('success' => 1, 'msg' => '');
                  //pr($rec1);
                  $user = array(
                        "id" => $rec1['user_id'],
                        "email" => $rec1['email'],
                        "name" => $rec1['name'],
                        "given_name" => $rec1['name'],
                        "family_name" => $rec1['name']
                  );

                  $_SESSION['user'] = $user;

            }
            else {
                 $return = array('success' => 0, 'msg' => 'Email/Password is incorrect');
            }



      }
  }
  catch (Exception $e) {
      $return = array('success' => 0, 'msg' => $e->getMessage());

  }
  echo json_encode($return);
  exit;
}
else
{
      $id = $_REQUEST['id'];
      //echo "id=" . $id;
      //exit;
      $email = $_REQUEST['emails'][0]['value'];

      $verified_email = $_REQUEST['verified'];
      $name = $_REQUEST['displayName'];
      $given_name=$_REQUEST['displayName'];

      $family_name=$_REQUEST['name']['familyName'];

      $link = $_REQUEST['url'];
      $picture = $_REQUEST['image']['url'];

      $gender = $_REQUEST['gender'];

      //$id = !empty($_REQUEST['id']) ? $_REQUEST['id']: 0;
      //echo $id . '\n' + $email . '\n' . $verified_email . '\n' . $name . '\n';
      //exit;
      $user = array(
                  "id" => $id,
                  "email" => $email,
                  "verified_email" => $verified_email,
                  "name" => $name,
                  "given_name" => $given_name,
                  "family_name" => $family_name,
                  "link" => $link,
                  "picture" => $picture,
                  "gender" => $gender
              );

      $_SESSION['user'] = $user;

      $rec = check_email($email);
      if (empty($rec)) {
            save($user, $type);
      }
      pr($_SESSION['user']);
      exit;
}

function check_email($email){
      $model = new Models_General();
      $params['where'] = " and email=  ".$model->qstr($email);
      $return = $model->getDetails('auth',$params);
      //pr($return);
      //exit;
      return $return;
}

?>