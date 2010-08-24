<?php

class Application_Model_DbTable_Brutstaetten extends Zend_Db_Table_Abstract
{

    protected $_name = 'BRUTSTAETTEN';

    public function addBrutstaette($groesse, $gew_art, $zugang, $bek_art, $text,
                                             $kontakt ,$g_id, $p_id, $checked) {
        $brutdata = array('B_GROESSE' => $groesse,
                          'B_GEWAESSER_ART' => $gew_art,
                          'B_ZUGANG' => $zugang,
                          'B_BEK_ART' => $bek_art,
                          'B_TEXT' => $text,
                          'B_KONTAKTDATEN' => $kontakt,
                          'B_G_ID' => $g_id,
                          'B_P_ID' => $p_id,
                          'B_CHECKED' => $checked
                          );

                        return($this->insert($brutdata));

    }

    public function updateBrutstaette($groesse, $gew_art, $zugang, $bek_art, $text, $kontakt, $g_id, $p_id, $checked) {
        $data = array('B_GROESSE' => $groesse,
                      'B_GEWAESSER_ART' => $gew_art,
                      'B_ZUGANG' => $zugang,
                      'B_BEK_ART' => $bek_art,
                      'B_TEXT' => $text,
                      'B_KONTAKTDATEN' => $kontakt,
                      'B_G_ID' => $g_id,
                      'B_P_ID' => $p_id,
                      'B_CHECKED' => $checked
                      );
       $where = $this->getAdapter()->quoteInto('B_G_ID = ?', $g_id);
       $this->update($data, $where);
       }

    public function deleteBrutstätte($id) {

        $this->delete('B_ID =' . (int) $id);
    }

     public function setChecked($g_id) {
        $data = array(
       'B_CHECKED'      => '1'
        );
       $where = $this->getAdapter()->quoteInto('B_G_ID = ?', $g_id);
       $this->update($data, $where);
       }



}

