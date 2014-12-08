<?php
///api/activity/new
class App_activity_new extends App_base
{
    public function execute()
    {
      $request = $_REQUEST;
      if (empty($request['user_id'])) {
        throw new Exception('missing user id');
      }
      if (empty($request['ac_name'])) {
        throw new Exception('missing name');
      }
      if (empty($request['lat'])) {
        throw new Exception('missing latitude');
      }
      if (empty($request['lng'])) {
        throw new Exception('missing longitude');
      }
      if (empty($request['address'])) {
        throw new Exception('missing address');
      }
      //first data for new activity
      $data = array();
      $data['activity_id'] = guid();
      $data['user_id'] = !empty($request['user_id']) ? $request['user_id'] : '';
      $data['ac_name'] = !empty($request['ac_name']) ? $request['ac_name'] : '';
      $data['ac_description'] = !empty($request['ac_description']) ? $request['ac_description'] : '';
      $data['ac_images'] = !empty($request['ac_images']) ? json_encode($request['ac_images']) : '';
      $data['ac_lat'] = !empty($request['lat']) ? $request['lat'] : '';
      $data['ac_lon'] = !empty($request['lng']) ? $request['lng'] : '';
      $data['ac_address'] = !empty($request['address']) ? $request['address'] : '';
      $data['status'] = 1;
      // data for new activity category
      $dataCat = array();
      $dataCat['activity_id'] = $data['activity_id'];
      $dataCat['category_id'] = !empty($request['category']) ? $request['category'] : '';
      $model = new Models_ActivityFinder();
      $r1 = $model->addNewActivity($data);
      $r2 = $model->addNewActivityCategory($dataCat);
      $this->return = array('confirm' => 'New Activity Class created successfully', 'id' => $data['activity_id']);
    }

}