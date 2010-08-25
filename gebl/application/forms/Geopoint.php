<?php

class Application_Form_Geopoint extends Zend_Form
{

    public function init()

    {
        $this->setMethod('post');
        
        $typ = new Zend_Form_Element_Select('G_TYP');
        $typ->setLabel('Typ: ')
              ->addValidator('alnum')
              ->setRequired(true)
              ->addMultiOptions(array(1 => 'Adresse',
                  2 => 'Falle',
                  3 => 'Brutstätte'));
        $name = new Zend_Form_Element_Text('G_NAME');
        $name->setLabel('Name: ')
              ->addValidator('Alnum', true, array('allowWhiteSpace' => true))
              ->setRequired(true);
        $lat = new Zend_Form_Element('G_LAT');
        $lat->setLabel('Lat: ')
              ->setRequired(true)
              //->addValidator('Float')
              ->addValidator('Between',true,array(0,180))
              //->setAttrib('disabled', 'true')
                ;
        $lon = new Zend_Form_Element('G_LON');
        $lon->setLabel('Lon: ')
               ->setRequired(true)
                //->addValidator('Float')
               ->addValidator('Between',true,array(0,180))
                //->setAttrib('disabled', 'true')
                ;

        $submit = new Zend_Form_Element_Submit('senden');
        $this->addElements(array($name, $typ, $lat, $lon, $submit));

    }


}

