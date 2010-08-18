<?php

class Application_Form_Brutstaette extends Zend_Form
{

    public function init()
    {
       $this->setMethod('post');

        $g_name = new Zend_Form_Element_Text('G_NAME');
        $g_name->setLabel('Name des Punktes: ')
              ->addValidator('Alnum', true, array('allowWhiteSpace' => true))
              ->setRequired(true);
        $lat = new Zend_Form_Element('G_LAT');
        $lat->setLabel('Breitengrad (Click auf Karte oder Eingabe in Dezimalgrad):')
              ->setRequired(true)
             //->addValidator('Float')
              ->addValidator('Between',true,array(46,49));
              //->setAttrib('disabled', 'true');
        $lon = new Zend_Form_Element('G_LON');
        $lon->setLabel('Längengrad (Click auf Karte oder Eingabe in Dezimalgrad):')
               ->setRequired(true)
               //->addValidator('Float')
               ->addValidator('Between',true,array(14,18));
                //->setAttrib('disabled', 'true');
        $b_name = new Zend_Form_Element_Text('B_NAME');
        $b_name->setLabel('Name der Brutstaette: ')
              ->addValidator('Alnum', true, array('allowWhiteSpace' => true))
              ->setRequired(true);
        $groesse = new Zend_Form_Element('B_GROESSE');
        $groesse->setLabel('Größe in m²: ')
              ->setRequired(true)
              ->addValidator('Int')
              ->addValidator('Between',true,array(0,100000));
        $gewaesser_art = new Zend_Form_Element_Text('B_GEWAESSER_ART');
        $gewaesser_art->setLabel('Gewässer Art: ')
              ->addValidator('Alnum', true, array('allowWhiteSpace' => true));
        $zugang = new Zend_Form_Element_Text('B_ZUGANG');
        $zugang->setLabel('Zugang: ')
              ->addValidator('Alnum', true, array('allowWhiteSpace' => true));
        $bek_art = new Zend_Form_Element_Text('B_BEK_ART');
        $bek_art->setLabel('Bekämpfung Art: ')
              ->addValidator('Alnum', true, array('allowWhiteSpace' => true));
        $text = new Zend_Form_Element_Textarea('B_TEXT');
        $text->setLabel('Text: ')
              //->addValidator('Alnum', true, array('allowWhiteSpace' => true))
              ->setAttrib('rows','5')
              ->setAttrib('cols','50')

              ;

        $submit = new Zend_Form_Element_Submit('senden');
        $this->addElements(array($g_name, $lat, $lon, $b_name, $groesse, $gewaesser_art, $zugang, $bek_art, $text ,$submit));

        //Layout
        $this->addDisplayGroup(array(
                    'G_NAME',
                    'G_LAT',
                    'G_LON',
                    ),'geopoint',array('legend' => 'Koordinaten des Punktes'));
        $contact = $this->getDisplayGroup('geopoint');
        $contact->setDecorators(array(
                    'FormElements',
                    'Fieldset',
                    array('HtmlTag',array('tag'=>'div','openOnly'=>true,'style'=>'float:left;'))
        ));
        $this->addDisplayGroup(array(
                    'B_NAME',
                    'B_GROESSE',
                    'B_GEWAESSER_ART',
                    'B_ZUGANG',
                    'B_BEK_ART',
                    'B_TEXT',
        ),'brutstaette',array('legend' => 'Daten zur Brutstaette'));
        $pass = $this->getDisplayGroup('brutstaette');
        $pass->setDecorators(array(
                'FormElements',
                'Fieldset',
                array('HtmlTag',array('style'=>'float:right'))
               ));
        $this->addDisplayGroup(array(
                    'senden',
                  ),'submitbutton',array('legend' => 'Daten Abschicken'));
        $pass = $this->getDisplayGroup('submitbutton');
        $pass->setDecorators(array(
                'FormElements',
                array('HtmlTag',array('tag'=>'div','closeOnly'=>true, 'style'=>'float:left'))
        ));


        $this->setDecorators(array(
                'FormElements',
                array('HtmlTag',array('tag'=>'div','style'=>'width:98%')),
                'Form'
        ));

    }


}

