<?php
///api/activity/search?lat=37.303&lon=-121.9778&radius=10
///api/activity/search?zip_id=40009&radius=10
///api/activity/search?city_id=1&radius=10
///api/activity/search?location_id=40009&radius=10
//&category[]=1&category[]=2&keyword=soccer
/*
 * lat, lon, radius
 * or zip_id, radius
 * or city_id, radius
 * and category
 * or keyword
*/
class App_activity_search extends App_base
{
    public function execute()
    {
      $request = $_REQUEST;
      $data = $request;
      if (!empty($request['lat']) && !empty($request['lon'])) {
        $data['type'] = 1;
      } else if (!empty($request['zip_id'])) {
        $data['type'] = 2;
      } else if (!empty($request['city_id'])) {
        $data['type'] = 3;
      } else if (!empty($request['location_id'])) {
        $data['type'] = 4;
      }
      $data['radius'] = 15;
      if (!empty($request['radius'])) {
        $data['radius'] = $request['radius'];
      }
      $data['category'] = !empty($request['category']) ? $request['category'] : '';
      $data['category_id'] = !empty($request['category_id']) ? $request['category_id'] : '';
      $data['keyword'] = !empty($request['keyword']) ? $request['keyword'] : '';
      $model = new Models_ActivityFinder();
      $return = $model->viewActivities($data);
      $this->return = $return;
    }

}