<?php
///api/geo/zip?q=9511
class App_geo_zip extends App_base
{
    public function execute()
    {
      $q = !empty($_GET['q']) ? $_GET['q'] : '';
      if (empty($q)) {
        throw new Exception('empty query');
      }
      $model = new Models_Geo();
      $data = $model->zip($q);
      $this->return = $data;
    }

}