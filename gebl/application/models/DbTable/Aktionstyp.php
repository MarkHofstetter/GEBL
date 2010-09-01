<?php

class Application_Model_DbTable_Aktionstyp extends Zend_Db_Table_Abstract {

    protected $_name = 'AKTIONSTYP';

    public function getAktionstypList() {

        $select = $this->select()
                  ->from($this->_name, 
                    array( 'key' => 'AT_NR' , 'value' => 'AT_NAME'));

        $result = $this->fetchAll($select)->toArray();

        return $result;
    }

}

