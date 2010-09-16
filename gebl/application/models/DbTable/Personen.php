<?php

class Application_Model_DbTable_Personen extends Zend_Db_Table_Abstract
{

    protected $_name = 'PERSONEN';

    public function addPerson($vorname, $nachname, $plz, $ort, $strasse,
                              $tel, $email, $logname, $passwort, $typ, $p_g_id ,$text) {
                                            
        $persondata = array('P_VORNAME' => $vorname,
                            'P_NACHNAME' => $nachname,
                            'P_PLZ' => $plz,
                            'P_ORT' => $ort,
                            'P_STRASSE' => $strasse,
                            'P_TEL' => $tel,
                            'P_EMAIL' => $email,
                            'P_LOGNAME' => $logname,
                            'P_PASSWORT' => $passwort,
                            'P_TYP' => $typ,
                            'P_G_ID' => $p_g_id,
                            'P_TEXT' => $text
                          );

                        return($this->insert($persondata));
    }

    public function updatePerson($p_id, $vorname, $nachname, $plz, $ort, $strasse,
                              $tel, $email, $logname, $passwort, $typ, $g_id, $text) {
        $data = array('P_VORNAME' => $vorname,
                            'P_NACHNAME' => $nachname,
                            'P_PLZ' => $plz,
                            'P_ORT' => $ort,
                            'P_STRASSE' => $strasse,
                            'P_TEL' => $tel,
                            'P_EMAIL' => $email,
                            'P_LOGNAME' => $logname,
                            'P_PASSWORT' => $passwort,
                            'P_TYP' => $typ,
                            'P_G_ID' => $g_id,
                            'P_TEXT' => $text
                          );
       $where = $this->getAdapter()->quoteInto('P_ID = ?', $p_id);
       $this->update($data, $where);
       }

    public function deletePerson($id) {

        $this->delete('P_ID =' . (int) $id);
    }
}

