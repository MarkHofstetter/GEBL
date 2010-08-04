<?php

class Application_Model_DbTable_GooglePoints extends Zend_Db_Table_Abstract {

    protected $_name = 'GOOGLE_POINTS';

    

    public function addPoint($cat, $name, $lat, $lng) {
        $data = null;
        $data = array(
            'G_P_CAT' => $cat,
            'G_P_NAME' => $name,
            'G_P_LAT' => $lat,
            'G_P_LNG' => $lng
        );

        $this->insert($data);

        }

    public function deletePoint($id) {

        $this->delete('G_P_ID =' . (int)$id);

        }

        
        
   

}

