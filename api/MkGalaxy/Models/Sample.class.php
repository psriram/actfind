<?php
class Models_Sample extends App_base
{
  
  public function selectExample($id=1, $cache=1)
  {
    $sql = sprintf("SELECT * FROM tomato WHERE id=%s", $this->qstr($id));
    if ($cache) {
      $result = $this->_connMain->CacheExecute(300, $sql);
    } else {
      $result = $this->_connMain->Execute($sql);
    }
    return $result->fields;
  }
  
  public function selectAllExample($cache=1)
  {
    $sql = sprintf("SELECT * FROM tomato");
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
