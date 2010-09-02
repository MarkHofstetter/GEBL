<?php

class Application_Model_DbTable_Fallen extends Zend_Db_Table_Abstract
{

    protected $_name = 'FALLEN';

    public function addFalle($typ, $text, $g_id, $p_id) {
        $fallendata = array('F_TYP' => $typ,
                          'F_P_ID' => $p_id,
                          'F_G_ID' => $g_id,
                          'F_TEXT' => $text
                          );

                        return($this->insert($fallendata));

    }

    public function updateFalle($typ, $text, $g_id, $p_id) {
        $data = array('F_TYP' => $typ,
                          'F_P_ID' => $p_id,
                          'F_G_ID' => $g_id,
                          'F_TEXT' => $text
                          );
       $where = $this->getAdapter()->quoteInto('F_G_ID = ?', $g_id);
       $this->update($data, $where);
       }

   public function getFallebyGeopoint ($g_id){
       $falle = $this->fetchRow('F_G_ID = ' . $g_id);
       return($falle);
   }

    public function deleteFalle($id) {

        $this->delete('F_ID =' . (int) $id);
    }

     

}

