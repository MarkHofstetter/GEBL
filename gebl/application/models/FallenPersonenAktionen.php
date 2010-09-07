<?php

require_once ('Zend/Db.php');

class Application_Model_FallenPersonenAktionen {

    protected $_db = null;

    function __construct() {
        $this->_db = Zend_Db_Table::getDefaultAdapter();
    }

    public function getOneFallenPersonen($g_id) {

        $select = $this->_db->select();
        $select->from(('FALLEN'),
                        array('*'))
                ->joinLeft('PERSONEN', 'FALLEN.F_P_ID = PERSONEN.P_ID', 'P_LOGNAME')
                ->where('F_G_ID = ?', $g_id);
        $stmt = $select->query();
        $result = $stmt->fetchAll();
        return ($result);
    }

    public function FallenPersonenAktionen2xml($fallenpersonen) {
        $dom = new DOMDocument("1.0");
        $node = $dom->createElement("fallen");
        $parnode = $dom->appendChild($node);
        header("Content-type: text/xml");

        foreach ($fallenpersonen as $falle) {
        $node = $dom->createElement("falle");
        $newnode = $parnode->appendChild($node);
        $parnode = $newnode;
        $newnode->setAttribute("f_id", $falle['F_ID']);
        $newnode->setAttribute("f_nr", $falle['F_NR']);
        $newnode->setAttribute("f_typ", $falle['F_TYP']);
        $newnode->setAttribute("f_p_id", $falle['F_P_ID']);
        $newnode->setAttribute("f_g_id", $falle['F_G_ID']);
        $newnode->setAttribute("f_text", $falle['F_TEXT']);
        $newnode->setAttribute("p_logname", $falle['P_LOGNAME']);
        $aktionenModel = new Application_Model_AktionenAktionstyp();
        $aktionen = $aktionenModel->getOneFalleAllAktionen($falle['F_ID']);
        foreach ($aktionen as $aktion) {
            $node = $dom->createElement("aktion");
            $newnode = $parnode->appendChild($node);
            $newnode->setAttribute("a_id", $aktion['A_ID']);
            $newnode->setAttribute("a_nr", $aktion['A_NR']);
            $newnode->setAttribute("at_name", $aktion['AT_NAME']);
            $newnode->setAttribute("a_datum", $aktion['A_DATUM']);
            $newnode->setAttribute("p_logname", $aktion['P_LOGNAME']);
            $newnode->setAttribute("a_text", $aktion['A_TEXT']);
        }
        }
        return ($dom);
    }


}