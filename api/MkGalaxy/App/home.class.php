<?php
///api/home
class App_home extends App_base
{
    public function execute()
    {
      $model = new Models_Sample();
      $data1 = $model->selectExample(1, 1);
      $data2 = $model->selectAllExample(1);
      $this->return = array($data1, $data2);
    }

}