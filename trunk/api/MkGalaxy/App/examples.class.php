<?php
///api/examples?type=App_geo_zip&q=95117
class App_examples extends App_base
{
  public function execute()
    {
      $type = !empty($_GET['type']) ? $_GET['type'] : '';
      if (empty($type)) {
        throw new Exception('empty type');
      }
      switch ($type) {
        case 'App_geo_zipID': // /api/examples?type=App_geo_zipID&id=40009
          $this->zipID();
          break;
        default:
          $obj = new $type();
          $obj->execute();
          $this->return = $obj->return;
          break;
      }
    }
    
    public function zipID()
    {
      $id = !empty($_GET['id']) ? $_GET['id'] : '';
      if (empty($id)) {
        throw new Exception ('zip id not found');
      }
      $model = new Models_Geo();
      $data = $model->zipById($id);
      $this->return = $data;
    }
}