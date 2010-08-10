<?php

class Application_Model_DbTable_Geodaten extends Zend_Db_Table_Abstract
{

    protected $_name = 'GEODATEN';


    public function addPoint($type, $name, $lat, $lon) {

        $data = array(
            'G_TYP' => $type,
            'G_NAME' => $name,
            'G_LAT' => $lat,
            'G_LON' => $lon
        );

        $this->insert($data);
    }

    public function deletePoint($id) {

        $this->delete('G_ID =' . (int) $id);
    }


}

