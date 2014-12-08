<?php
///api/activity/category
class App_activity_category extends App_base
{
    public function execute()
    {
      $model = new Models_ActivityFinder();
      $data = $model->category();
      $this->return = $data;
    }

}