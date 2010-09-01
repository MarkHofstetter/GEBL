<?php

class Application_Model_DbTable_Geodaten extends Zend_Db_Table_Abstract {

    protected $_name = 'GEODATEN';
    protected $_sequence = 'GEBL_SEQ';

    public function addGeodaten($name, $typ, $lat, $lon) {

        $data = array(
            'G_NAME' => $name,
            'G_TYP' => $typ,
            'G_LAT' => $lat,
            'G_LON' => $lon            
        );


        return($this->insert($data));
    }

    public function deleteGeodaten($id) {

        $this->delete('G_ID =' . (int) $id);
    }



    public function updateGeodaten($id, $name, $typ, $lat, $lon) {
        $data = array(
       'G_NAME' => $name,
       'G_TYP' => $typ,
       'G_LAT' => $lat,
       'G_LON' => $lon
       );
       $where = $this->getAdapter()->quoteInto('G_ID = ?', $id);
       $this->update($data, $where);
       }

  

    public function geodaten2xml($geodaten) {


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
            //$newnode->setAttribute("name", $point['G_NAME']);
            $newnode->setAttribute("typ", $point['G_TYP']);
            $newnode->setAttribute("lat", $point['G_LAT']);
            $newnode->setAttribute("lon", $point['G_LON']);
            //$newnode->setAttribute("checked", $point['G_CHECKED']);
        }

        return ($dom);
    }

     public function listAllGeodatenXML() {

        $allgeodaten = $this->fetchAll();
        return ($this->geodaten2xml($allgeodaten));
    }

    public function listBrutGeodatenXML() {

        $brutgeodaten = $this->fetchAll('G_TYP = ' . 3);
        return ($this->geodaten2xml($brutgeodaten));
    }

     public function getPersonenGeodaten($p_g_id) {

        $personengeodaten = $this->fetchRow('G_ID=' . $p_g_id)->toArray();
        return ($personengeodaten);
    }

     public function getGeodaten($g_id) {

        $geodaten = $this->fetchRow('G_ID=' . $g_id);
        return ($geodaten);
    }

}

