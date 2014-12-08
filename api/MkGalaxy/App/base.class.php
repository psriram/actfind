<?php
class App_base
{
    protected $_connMain;

    public $return = array();

    public function __construct()
    {
        global $connMainAdodb;
        $this->_connMain = $connMainAdodb;
        $this->_connMain->SetFetchMode(ADODB_FETCH_ASSOC);
        //$this->_connMain->debug = true;
    }

    protected function qstr($value)
    {
        return $this->_connMain->qstr($value);
    }

    
    

    public function getUser($uid, $type='googleplus', $useCache=true)
    {
      $sql = sprintf("SELECT * FROM auth WHERE uid = %s AND sn_type = %s", $this->qstr($uid), $this->qstr($type));
      if ($useCache)
          $result = $this->_connMain->CacheExecute(300, $sql);
      else
          $result = $this->_connMain->Execute($sql);
      $return = $result->fields;
      if (empty($result) || $result->EOF || empty($return)) throw new Exception ("No User Found.");
       return $return;
    }

    public function checkUser($uid, $type='googleplus', $cache=1)
    {
      $user = $this->getUser($uid, $type, $cache);
      if (empty($user)) {
        throw new Exception('User not found');
      }
    }
    
    public function getUserByID($user_id, $useCache=true)
    {
      $sql = sprintf("SELECT * FROM auth WHERE user_id = %s", $this->qstr($user_id));
      if ($useCache)
          $result = $this->_connMain->CacheExecute(300, $sql);
      else
          $result = $this->_connMain->Execute($sql);
      $return = $result->fields;
      if (empty($result) || $result->EOF || empty($return)) throw new Exception ("No User Found.");
       return $return;
    }

    public function checkUserByID($user_id, $cache=1)
    {
      $user = $this->getUserByID($user_id, $cache);
      if (empty($user)) {
        throw new Exception('User not found');
      }
    }
}