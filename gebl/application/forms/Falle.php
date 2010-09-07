<?php

class Application_Form_Falle extends Zend_Form {

    public function init() {
        $this->setMethod('post');


        $zoom = new Zend_Form_Element_Hidden('ZOOM');
        $zoom->removeDecorator('Label');
        //store zoom for redraw in case of wrong input
        $g_id = new Zend_Form_Element_Hidden('G_ID');
        $g_id->removeDecorator( 'Label' );

        $g_name = new Zend_Form_Element_Text('G_NAME');
        $g_name->setLabel('Name (optional): ')
                ->addValidator('Alnum', true, array('allowWhiteSpace' => true))
                //->setRequired(true)
                ->addValidator('StringLength', false, array(0, 50))
                ->setAttrib('size', '70');
        
        $g_lat = new Zend_Form_Element('G_LAT');
        $g_lat->setLabel('* Breitengrad (Auf Karte klicken oder Eingabe in Dezimalgrad):')
                ->setRequired(true)
                ->addValidator('regex', true,
                        array('pattern' => '/^(\+?((([0-9]+(\.)?)|([0-9]*\.[0-9]+))([eE][+-]?[0-9]+)?))$/',
                            'messages' => array(
                                'regexInvalid' => "Ungültiger Wert!",
                                'regexNotMatch' => "Ungültige Eingabe!",
                                'regexErrorous' => "There was an internal error while using the pattern '%pattern%'"
                        )))
                ->addValidator('Between', true, array(46, 49));
        //->setAttrib('disabled', 'true');
        
        $g_lon = new Zend_Form_Element('G_LON');
        $g_lon->setLabel('* Längengrad (Auf Karte klicken oder Eingabe in Dezimalgrad):')
                ->setRequired(true)
                ->addValidator('regex', true,
                        array('pattern' => '/^(\+?((([0-9]+(\.)?)|([0-9]*\.[0-9]+))([eE][+-]?[0-9]+)?))$/',
                            'messages' => array(
                                'regexInvalid' => "Ungültiger Wert!",
                                'regexNotMatch' => "Ungültige Eingabe!",
                                'regexErrorous' => "There was an internal error while using the pattern '%pattern%'"
                        )))
                ->addValidator('Between', true, array(14, 18));
        //->setAttrib('disabled', 'true');
 
        $f_typ = new Zend_Form_Element('F_TYP');
        $f_typ->setLabel('Fallen-Typ (optional, maximal 100 Zeichen):')
                ->addValidator('Alnum', true, array('allowWhiteSpace' => true))
                //->setRequired(true)
                ->setAttrib('size', '70')
                ->addValidator('StringLength', false, array(0, 100));

        $f_text = new Zend_Form_Element_Textarea('F_TEXT');
        $f_text->setLabel('Kommentar (optional, maximal 1024 Zeichen):')
                //->addValidator('Alnum', true, array('allowWhiteSpace' => true))
                //->setRequired(true)
                ->setAttrib('rows', '5')
                ->setAttrib('cols', '60')
                ->addValidator('StringLength', false, array(0, 1024));

        $submit = new Zend_Form_Element_Submit('senden');

        $this->addElements(array($zoom, $g_name, $g_id, $g_lat, $g_lon, $f_typ, $f_text, $submit));

    }

}

