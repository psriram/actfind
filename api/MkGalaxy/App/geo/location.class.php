<?php
///api/geo/location?q=9511
class App_geo_location extends App_base
{
    public function execute()
    {
      $q = !empty($_GET['q']) ? $_GET['q'] : '';
      if (empty($q)) {
        throw new Exception('empty query');
      }
      $model = new Models_Geo();
      if (is_numeric($q)) {
        $data = $model->zip($q);
        if (!empty($data)) {
          foreach ($data as $k => $v) {
            $zipcode = $v['zipcode'].', '.$v['city'].', '.$v['state'].', '.$v['country'];
            echo 'z:'.$v['z_id']."|".$zipcode."\n";
          }
        }
        exit;
      } else {
        $data = $model->findcity($q);
        if (!empty($data)) {
          foreach ($data as $k => $v) {
            $city = $v['city'].', '.$v['statename'].', '.$v['countryname'];
            echo 'c:'.$v['id']."|".$city."\n";
          }
        }
        exit;
      }
      $this->return = $data;
    }

}