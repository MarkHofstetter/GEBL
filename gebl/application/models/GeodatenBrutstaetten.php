<?php

require_once ('Zend/Db.php');

class Application_Model_GeodatenBrutstaetten {
    protected $_db=null;

    function  __construct() {
        $this->_db = Zend_Db_Table::getDefaultAdapter();
    }



    public function getallgeodatenbrutstaetten(){

       $select = $this->_db->select();
       $select->from(('GEODATEN'),
                   array('G_ID', 'G_LAT', 'G_TYP', 'G_LON' , 'G_NAME'))
               ->join('BRUTSTAETTEN','GEODATEN.G_ID = BRUTSTAETTEN.B_G_ID','B_CHECKED');
         $stmt = $select->query();
         $result = $stmt->fetchAll();
         return ($result);
       
        }

        public function getallgeodatenAndbrutstaettenstatus(){

       $select = $this->_db->select();
       $select->from(('GEODATEN'),
                   array('G_ID', 'G_LAT', 'G_TYP', 'G_LON' , 'G_NAME'))
               ->joinLeft('BRUTSTAETTEN','GEODATEN.G_ID = BRUTSTAETTEN.B_G_ID','B_CHECKED');
         $stmt = $select->query();
         $result = $stmt->fetchAll();
         return ($result);

        }



    public function geodatenbrutstaetten2xml($geodaten) {


        $dom = new DOMDocument("1.0");
        $node = $dom->createElement("markers");
        $parnode = $dom->appendChild($node);
        header("Content-type: text/xml");

       // Iterate through the rows, adding XML nodes for each
       foreach ($geodaten as $point) {
           // ADD TO XML DOCUMENT NODE
            $node = $dom->createElement("marker");
            $newnode = $parnode->appendChild($node);
            $newnode->setAttribute("id", $point['G_ID']);
            $newnode->setAttribute("name", $point['G_NAME']);
            $newnode->setAttribute("typ", $point['G_TYP']);
            $newnode->setAttribute("lat", $point['G_LAT']);
            $newnode->setAttribute("lon", $point['G_LON']);
            $newnode->setAttribute("checked", $point['B_CHECKED']);
        }

        return ($dom);
    }

    public function listBrutGeodatenXML() {

        $geodaten = $this->getallgeodatenbrutstaetten();
        return ($this->geodatenbrutstaetten2xml($geodaten));
    }

     public function listAllGeodatenAndBrutCheckedXML() {

        $allgeodaten = $this->getallgeodatenAndbrutstaettenstatus();
        return ($this->geodatenbrutstaetten2xml($allgeodaten));
    }

    function getSysDate() { //for test only


    $res = $this->db->fetchAll("SELECT sysdate FROM dual");
    return $res['SYSDATE'];
      }
}