<?php

class Application_Model_DbTable_Brutstaetten extends Zend_Db_Table_Abstract
{

    protected $_name = 'BRUTSTAETTEN';

    public function addBrutstaette($name, $groesse, $gew_art, $zugang, $bek_art, $text, $g_id, $p_id) {
        $brutdata = array('B_NAME' => $name,
                          'B_GROESSE' => $groesse,
                          'B_GEWAESSER_ART' => $gew_art,
                          'B_ZUGANG' => $zugang,
                          'B_BEK_ART' => $bek_art,
                          'B_TEXT' => $text,
                          'B_G_ID' => $g_id,
                          'B_P_ID' => $p_id
                          );

                        return($this->insert($brutdata));

    }

    public function updateBrutstaette($name, $groesse, $gew_art, $zugang, $bek_art, $text, $g_id, $p_id) {
        $data = array('B_NAME' => $name,
                      'B_GROESSE' => $groesse,
                      'B_GEWAESSER_ART' => $gew_art,
                      'B_ZUGANG' => $zugang,
                      'B_BEK_ART' => $bek_art,
                      'B_TEXT' => $text,
                      'B_G_ID' => $g_id,
                      'B_P_ID' => $p_id
                      );
       $where = $this->getAdapter()->quoteInto('B_G_ID = ?', $g_id);
       $this->update($data, $where);
       }

    public function deleteBrutstätte($id) {

        $this->delete('B_ID =' . (int) $id);
    }

}

