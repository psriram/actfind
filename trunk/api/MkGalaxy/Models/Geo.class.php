<?php
class Models_Geo extends App_base
{
  
  public function zip($q, $cache=1)
  {
    $q = trim($q);
    if (empty($q)) {
      throw new Exception('empty query');
    }
    $key = $this->qstr("%".$q."%");
    $sql = sprintf("SELECT * FROM geo_zipcodes WHERE zipcode LIKE %s ORDER BY city", $key);
    if ($cache) {
      $result = $this->_connMain->CacheExecute(_FUNC_TIME_YEAR, $sql);
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
  
  public function zipById($id, $cache=1)
  {
    $sql = sprintf("SELECT * FROM geo_zipcodes WHERE z_id=%s", $this->qstr($id));
    if ($cache) {
      $result = $this->_connMain->CacheExecute(_FUNC_TIME_YEAR, $sql);
    } else {
      $result = $this->_connMain->Execute($sql);
    }
    return $result->fields;
  }
  
  public function cityById($id, $cache=1)
  {
    $sql = sprintf("SELECT * FROM geo_cities WHERE cty_id=%s", $this->qstr($id));
    if ($cache) {
      $result = $this->_connMain->CacheExecute(_FUNC_TIME_YEAR, $sql);
    } else {
      $result = $this->_connMain->Execute($sql);
    }
    return $result->fields;
  }
  
	

	public function findcity($keyword='', $country=223)
	{
		$this->_connMain->Execute("SET NAMES utf8");
    $city = '%'.$keyword.'%';
		$sql = "select geo_cities.*, geo_states.name as statename, geo_countries.name as countryname from geo_cities left join geo_states on geo_cities.sta_id = geo_states.sta_id  left join geo_countries on geo_cities.con_id = geo_countries.con_id WHERE geo_cities.name like ".$this->_connMain->qstr($city)." AND geo_countries.con_id = ".$this->_connMain->qstr($country)." order by geo_cities.name, geo_states.name, geo_countries.name";
		$recordSet = $this->_connMain->CacheExecute(_FUNC_TIME_DAY, $sql);
		$return = array();
		while (!$recordSet->EOF) {
			$return[] = array('id' => $recordSet->fields['cty_id'], 'sta_id' => $recordSet->fields['sta_id'], 'con_id' => $recordSet->fields['con_id'], 'city' => $recordSet->fields['name'], 'latitude' => $recordSet->fields['latitude'], 'longitude' => $recordSet->fields['longitude'], 'statename' => $recordSet->fields['statename'], 'countryname' => $recordSet->fields['countryname']);
			$recordSet->MoveNext();
		}
		return $return;
	}
}
