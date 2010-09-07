<?php

require_once ('Zend/Db.php');

class Application_Model_BrutstaettenPersonenAktionen {

    protected $_db = null;

    function __construct() {
        $this->_db = Zend_Db_Table::getDefaultAdapter();
    }

    public function getOneBrutPersonen($g_id) {

        $select = $this->_db->select();
        $select->from(('BRUTSTAETTEN'),
                        array('*'))
                ->joinLeft('PERSONEN', 'BRUTSTAETTEN.B_P_ID = PERSONEN.P_ID', 'P_LOGNAME')
                ->where('B_G_ID = ?', $g_id);
        $stmt = $select->query();
        $result = $stmt->fetchAll();
        return ($result);
    }

    public function BrutPersonenAktionen2xml($brutstperson) {
        $dom = new DOMDocument("1.0");
        $node = $dom->createElement("brutstaetten");
        $parnode = $dom->appendChild($node);
        header("Content-type: text/xml");

        foreach ($brutstperson as $brutperson) {
        $node = $dom->createElement("brutstaette");
        $newnode = $parnode->appendChild($node);
        $parnode = $newnode;
        $newnode->setAttribute("b_id", $brutperson['B_ID']);
        $newnode->setAttribute("b_nr", $brutperson['B_NR']);
        $newnode->setAttribute("b_groesse", $brutperson['B_GROESSE']);
        $newnode->setAttribute("b_gewaesser_art", $brutperson['B_GEWAESSER_ART']);
        $newnode->setAttribute("b_zugang", $brutperson['B_ZUGANG']);
        $newnode->setAttribute("b_p_id", $brutperson['B_P_ID']);
        $newnode->setAttribute("b_g_id", $brutperson['B_G_ID']);
        $newnode->setAttribute("b_bek_art", $brutperson['B_BEK_ART']);
        $newnode->setAttribute("b_text", $brutperson['B_TEXT']);
        $newnode->setAttribute("b_kontaktdaten", $brutperson['B_KONTAKTDATEN']);
        $newnode->setAttribute("p_logname", $brutperson['P_LOGNAME']);
        $aktionenModel = new Application_Model_AktionenAktionstyp();
        $aktionen = $aktionenModel->getOneBrutstaetteAllAktionen($brutperson['B_ID']);
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