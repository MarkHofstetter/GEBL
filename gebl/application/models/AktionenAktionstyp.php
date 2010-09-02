 <?php

require_once ('Zend/Db.php');

class Application_Model_AktionenAktionstyp {
    protected $_db=null;

    function  __construct() {
        $this->_db = Zend_Db_Table::getDefaultAdapter();
    }


    public function getOneBrutstaetteAllAktionen($b_id){

       $select = $this->_db->select();
       $select->from(('AKTIONEN'),
                   array('A_ID', 'A_NR', 'A_DATUM', 'A_TEXT'))
               ->join('AKTIONSTYP','AKTIONEN.A_TYP = AKTIONSTYP.AT_NR','AT_NAME')
               ->where('A_B_ID = ?', $b_id)
               ->order('A_DATUM ASC');
         $stmt = $select->query();
         $result = $stmt->fetchAll();
         return ($result);
    }

     public function getOneFalleAllAktionen($f_id){

       $select = $this->_db->select();
       $select->from(('AKTIONEN'),
                   array('A_ID', 'A_NR', 'A_DATUM', 'A_TEXT'))
               ->join('AKTIONSTYP','AKTIONEN.A_TYP = AKTIONSTYP.AT_NR','AT_NAME')
               ->where('A_F_ID = ?', $f_id)
               ->order('A_DATUM ASC');
         $stmt = $select->query();
         $result = $stmt->fetchAll();
         return ($result);
    }

    public function aktionen2xml ($aktionen){
        $dom = new DOMDocument("1.0");
        $node = $dom->createElement("aktionen");
        $parnode = $dom->appendChild($node);
        header("Content-type: text/xml");
        if (count($aktionen)>0){
        foreach ($aktionen as $aktion) {
          $node = $dom->createElement("aktion");
          $newnode = $parnode->appendChild($node);
          $newnode->setAttribute("a_id",$aktion['A_ID']);
          $newnode->setAttribute("a_nr",$aktion['A_NR']);
          $newnode->setAttribute("a_datum",$aktion['A_DATUM']);
          $newnode->setAttribute("a_text",$aktion['A_TEXT']);
          $newnode->setAttribute("at_text",$aktion['AT_NAME']);

          }
        }
    return ($dom);

    }




    function getSysDate() { 
    $res = $this->_db->fetchRow("SELECT sysdate FROM dual");
    return $res['SYSDATE'];
      }
}