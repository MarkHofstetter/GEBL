<?php

class Application_Model_DbTable_Aktionen extends Zend_Db_Table_Abstract {

    protected $_name = 'AKTIONEN';



    public function addAktion($a_typ, $a_betreff, $a_datum, $a_p_id,
                           $a_b_id, $a_f_id, $a_text) {
        $aktiondata = array('A_TYP' => $a_typ,
                          'A_BETREFF' => $a_betreff,
                          'A_DATUM' => $a_datum,
                          'A_P_ID' => $a_p_id,
                          'A_B_ID' => $a_b_id,
                          'A_F_ID' => $a_f_id,
                          'A_TEXT' => $a_text
                           );

                        return($this->insert($aktiondata));

    }
   

}

