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



    function getSysDate() { //for test only


    $res = $this->db->fetchAll("SELECT sysdate FROM dual");
    return $res['SYSDATE'];
      }
}