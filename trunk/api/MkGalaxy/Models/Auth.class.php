<?php
class Models_Auth extends App_base
{
    public function getUser($uid, $type='googleplus', $useCache=true)
    {
      $sql = sprintf("SELECT * FROM auth WHERE uid=%s AND sn_type=%s", $this->qstr($uid), $this->qstr($type));
      if ($useCache)
          $result = $this->_connMain->CacheExecute(300, $sql);
      else
          $result = $this->_connMain->Execute($sql);
      $return = $result->fields;
      if (empty($result) || $result->EOF || empty($return)) throw new Exception ("No User Found.");
       return $return;
    }

    public function getUserByUserID($userID, $useCache=true)
    {
      $sql = sprintf("SELECT * FROM auth WHERE user_id=%s", $this->qstr($userID));
      if ($useCache)
          $result = $this->_connMain->CacheExecute(300, $sql);
      else
          $result = $this->_connMain->Execute($sql);
      $return = $result->fields;
      if (empty($result) || $result->EOF || empty($return)) throw new Exception ("No User Found.");
       return $return;
    }
}