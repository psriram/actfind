<?php
//http://mkhancha.mkgalaxy.com/api/users/detail?uid=100546875099861959996&cache=1&type=googleplus
class App_users_detail extends App_base
{
    public function execute()
    {
      if (empty($_GET['uid'])) {
        throw new Exception('Enter uid');
      }
      $type = 'googleplus';
      if (!empty($_GET['type'])) {
        $type = $_GET['type'];
      }
      $uid = $_GET['uid'];
      $cache = isset($_GET['cache']) ? $_GET['cache'] : 1;
      $Models = new Models_Auth();
      $return = $Models->getUser($uid, $type, $cache);
      $this->return = $return;
    }
}