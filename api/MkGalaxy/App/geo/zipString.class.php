<?php
// /api/geo/zipString?q=9511
class App_geo_zipString extends App_base
{
    public function execute()
    {
      try {
      $q = !empty($_GET['q']) ? $_GET['q'] : '';
      if (empty($q)) {
        throw new Exception('empty query');
      }
      $model = new Models_Geo();
      $data = $model->zip($q);
      $return = array();
      $fieldSeparater = ' | ';
      foreach ($data as $k => $v) {
        $str = $v['zipcode'].' '.$v['city'].', '.$v['state'].', '.$v['country'];
        $return[] = $str.';'.$v['z_id'];
      }
      echo implode($fieldSeparater, $return);
      } catch (Exception $e) {
        echo $e->getMessage();
      }
      exit;
    }

}