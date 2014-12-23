<?php
class Models_General extends App_base
{
    public function addDetails($tableName, $data=array(), $user_id='')
    {
      if (!empty($user_id)) {
          $this->checkUserByID($user_id);
      }
      $insertSQL = $this->_connMain->AutoExecute($tableName, $data, 'INSERT');
      $id = $this->_connMain->Insert_ID();
      return $id;
    }

    public function updateDetails($tableName, $data=array(), $where='')
    {
      if (empty($where)) {
          throw new Exception('could not update');
      }
      $updateSQL = $this->_connMain->AutoExecute($tableName, $data, 'UPDATE', $where);
      return true;
    }

  public function getDetails($tableName, $params=array(), $cache=0)
  {
    $where = !empty($params['where']) ? $params['where'] : '';
    $group = !empty($params['group']) ? $params['group'] : '';
    $order = !empty($params['order']) ? $params['order'] : '';
    $fields = !empty($params['fields']) ? $params['fields'] : '*';
    $sql = sprintf("SELECT $fields FROM $tableName WHERE 1 $where $group $order");
    //echo($sql);

    if ($cache) {
      $result = $this->_connMain->CacheExecute(300, $sql);
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