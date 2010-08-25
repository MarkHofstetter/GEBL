<?php

class Application_Form_Point extends Zend_Form
{

    public function init()

    {
        $this->setMethod('post');
        
        $cat = new Zend_Form_Element_Select('G_P_CAT');
        $cat->setLabel('Kategorie: ')
              ->addValidator('alnum')
              ->setRequired(true)
              ->addMultiOptions(array('Adresse' => 'Adresse',
                  'Falle' => 'Falle',
                  'Brutstätte' => 'Brutstätte'));
        $name = new Zend_Form_Element_Text('G_P_NAME');
        $name->setLabel('Name: ')
              ->addValidator('Alnum', true, array('allowWhiteSpace' => true))
              ->setRequired(true);
        $lat = new Zend_Form_Element('G_P_LAT');
        $lat->setLabel('Lat: ')
              ->setRequired(true)
              //->addValidator('Float')
              ->addValidator('Between',true,array(0,180))
              //->setAttrib('disabled', 'true')
                ;
        $lng = new Zend_Form_Element('G_P_LNG');
        $lng->setLabel('Lon: ')
               ->setRequired(true)
                //->addValidator('Float')
               ->addValidator('Between',true,array(0,180))
                //->setAttrib('disabled', 'true')
                ;

        $submit = new Zend_Form_Element_Submit('senden');
        $this->addElements(array($name, $cat, $lat, $lng, $submit));

    }


}

