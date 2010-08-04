<?php

require_once ('Zend/Db.php');

class Application_Model_HRModel {
    protected $db=null;
    
    function  __construct() {
        $this->db = Zend_Db_Table::getDefaultAdapter();
    }

    function getSysDate() {
    $res = $this->db->fetchRow("SELECT sysdate FROM dual");
    return $res['SYSDATE'];
      }
}

