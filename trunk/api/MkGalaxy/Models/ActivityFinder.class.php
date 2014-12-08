<?php
class Models_ActivityFinder extends App_base
{
  public function addNewActivity($data)
  {
      $Models_Auth = new Models_Auth();
      $user = $Models_Auth->getUserByUserID($data['user_id']);
      if (empty($user)) {
        throw new Exception('User not found');
      }
      $data['ac_updated'] = date('Y-m-d H:i:s');
      $insertSQL = $this->_connMain->AutoExecute('activities', $data, 'INSERT');
      return true;
  }

  public function addNewActivityCategory($data)
  {
      if (empty($data['category_id'])) {
        return false;
      }
      if (!is_array($data['category_id'])) {
        $data['category_id'] = array($data['category_id']);
      }
      foreach ($data['category_id'] as $category_id) {
        $arr = array();
        $arr['category_id'] = $category_id;
        $arr['activity_id'] = $data['activity_id'];
        $insertSQL = $this->_connMain->AutoExecute('activities_cats', $arr, 'INSERT');
      }
      return true;
  }

  public function deleteNewActivity($id, $uid)
  {

  }

  public function editNewActivity($id, $data, $uid)
  {

  }

  /*
   *@params float $params['lat']
   *@params float $params['lon']
   *@params float $params['radius']
   *@params string $params['keyword']
   *@params array of strings $params['category'][] = 'karate', $params['category'][] = 'judo'
   *
   */
  public function viewActivities($params=array(), $nrows=100, $offset=0, $cache=1)
  {
    $selectSql = '';
    $categorySql = '';
    $keywordSql = '';
    $locationSql = '';
    $orderBy = '';
    //category search
    if (!empty($params['category'])) {
      $keywordSql = " AND (categories.category LIKE ".$this->qstr('%'.$params['category'].'%').")";
    }
    //category search
    if (!empty($params['category_id']) && !is_array($params['category_id'])) {
      $params['category_id'] = array($params['category_id']);
    }
    if (!empty($params['category_id'])) {
      $tmp = array();
      foreach ($params['category_id'] as $cat) {
        $tmp[] = "activities_cats.category_id = ".$this->qstr($cat);
      }
      $categorySql = implode(' OR ', $tmp);
      $categorySql = ' AND ('.$categorySql.')';
    }
    //keyword search
    if (!empty($params['keyword'])) {
      $keywordSql = " AND (activities.ac_name LIKE ".$this->qstr('%'.$params['keyword'].'%')." OR activities.ac_description LIKE ".$this->qstr('%'.$params['keyword'].'%')." OR categories.category LIKE ".$this->qstr('%'.$params['keyword'].'%').")";
    }

    if (!empty($params['type'])) {
      $locationFlag = false;
      $radius = $params['radius'];
      $Models_Geo = new Models_Geo();
      switch ($params['type']) {
        case 1:
          $lat = $params['lat'];
          $lon = $params['lon'];
          $locationFlag = true;
          break;
        case 2:
          //get latitude and longitude from zip code
          $zipData = $Models_Geo->zipById($params['zip_id']);
          $lat = $zipData['z_lat'];
          $lon = $zipData['z_lon'];
          $locationFlag = true;
          break;
        case 3:
          $cityData = $Models_Geo->cityById($params['city_id']);
          $lat = $cityData['latitude'];
          $lon = $cityData['longitude'];
          $locationFlag = true;
        case 4:
          $id = $params['location_id'];
          $part = substr($id, 0, 1);
          $loc = substr($id, 2);
          if ($part == 'c') {
            $cityData = $Models_Geo->cityById($loc);
            $lat = $cityData['latitude'];
            $lon = $cityData['longitude'];
          } else if ($part == 'z') {
            $zipData = $Models_Geo->zipById($loc);
            $lat = $zipData['z_lat'];
            $lon = $zipData['z_lon'];
          }
          $locationFlag = true;
          break;
      }
      if (!empty($locationFlag)) {
          $selectSql = ", (ROUND( DEGREES(ACOS(SIN(RADIANS(".GetSQLValueString($lat, 'double').")) * SIN(RADIANS(activities.ac_lat)) + COS(RADIANS(".GetSQLValueString($lat, 'double').")) * COS(RADIANS(activities.ac_lat)) * COS(RADIANS(".GetSQLValueString($lon, 'double')." -(activities.ac_lon)))))*60*1.1515,2)) as distance";
          $locationSql = " AND ((ROUND( DEGREES(ACOS(SIN(RADIANS(".GetSQLValueString($lat, 'double').")) * SIN(RADIANS(activities.ac_lat)) + COS(RADIANS(".GetSQLValueString($lat, 'double').")) * COS(RADIANS(activities.ac_lat)) * COS(RADIANS(".GetSQLValueString($lon, 'double')." -(activities.ac_lon)))))*60*1.1515,2)) <= ".GetSQLValueString($radius, 'int').")";
          $orderBy = ' ORDER BY distance';
      }
    }
    $sql = "SELECT activities.* $selectSql FROM activities LEFT JOIN activities_cats ON activities.activity_id = activities_cats.activity_id LEFT JOIN categories ON activities_cats.category_id = categories.category_id WHERE 1 $categorySql $keywordSql $locationSql $orderBy";

    if (!empty($cache)) {
      $result = $this->_connMain->CacheSelectLimit(5, $sql, $nrows, $offset); //change to 1000 after some time
    } else {
      $result = $this->_connMain->SelectLimit($sql, $nrows, $offset);
    }
    if (empty($result) || $result->EOF) throw new Exception ("No posting found.");
    $return = array();
    while (!$result->EOF) {
        $xtras = json_decode($result->fields['xtras'], 1);
        $result->fields['xtras'] = $xtras;
        $return[] = $result->fields;
        $result->MoveNext();
     }
    return $return;
  }

  public function category()
  {
      $sql = sprintf("SELECT * FROM categories");
      if ($cache) {
        $result = $this->_connMain->CacheExecute(_FUNC_TIME_ZERO, $sql);
      } else {
        $result = $this->_connMain->Execute($sql);
      }
      $return = array();
      while (!$result->EOF) {
        $return[] = $result->fields;
        $result->MoveNext();
      }
      return $return;
  }
}