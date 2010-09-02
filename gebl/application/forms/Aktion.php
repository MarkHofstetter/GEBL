<?php

class Application_Form_Aktion extends Zend_Form
{

    public function init()
    {
       $this->setMethod('post');


       $zoom = new Zend_Form_Element_Hidden('ZOOM');
         $zoom->removeDecorator( 'Label' );
         //store zoom for redraw in case of wrong input

        $g_id = new Zend_Form_Element_Hidden('G_ID');
        $g_id->removeDecorator( 'Label' );
         //store g_id for storing in db

        $g_lat = new Zend_Form_Element_Hidden('G_LAT');
        $g_lat->removeDecorator( 'Label' );
         //store lat for redraw in case of wrong input
        $g_lon = new Zend_Form_Element_Hidden('G_LON');
        $g_lon->removeDecorator( 'Label' );
         //store lon for redraw in case of wrong input

        $aktionen = new Application_Model_AktionenAktionstyp;
        $date = $aktionen->getSysDate();
        $a_datum = new Zend_Form_Element('A_DATUM');
        $a_datum->setLabel('* Datum (Format TT.MM.JJ): ')
              ->setRequired(true)
              ->addValidator('Date',false, array('format'=>'dd.MM.yy'))
              ->addValidator('regex', false, 
                array('pattern' => '/^[0-3][0-9]\.[0-1][0-9]\.[0-9][0-9]$/',
                'messages' => array(
                'regexInvalid'   => "Ungültiger Wert!",
                'regexNotMatch' => "Ungültige Eingabe!",
                'regexErrorous'  => "There was an internal error while using the pattern '%pattern%'"
                )))
              ->setAttrib('size','8')
              ->setValue($date);

         $aktionstyp = new Application_Model_DbTable_Aktionstyp;
         $aktionenList = $aktionstyp->getAktionstypList();
         $a_typ = new Zend_Form_Element_Select('A_TYP');
         $a_typ->setLabel('* Typ: ')
              ->setRequired(true)
              ->addMultiOptions($aktionenList);
         
        $a_text = new Zend_Form_Element_Textarea('A_TEXT');
        $a_text->setLabel('* Kommentar (maximal 1024 Zeichen):')
              //->addValidator('Alnum', true, array('allowWhiteSpace' => true))
              ->setRequired(true)
              ->setAttrib('rows','5')
              ->setAttrib('cols','60')
              ->addValidator('StringLength', false, array(0, 1024));
        
        $submit = new Zend_Form_Element_Submit('senden');

        $this->addElements(array($g_lat, $g_lon, $g_id, $zoom, $a_datum, $a_typ, $a_text, $submit));

        $this->addDisplayGroup(array('A_DATUM', 'A_TYP'), 'datetyp');
        $this->addDisplayGroup(array('A_TEXT', 'senden'), 'textsubmit');
        $this->getDisplayGroup('datetyp')->setDecorators(array('FormElements',
                                      array('HtmlTag', array('tag' => 'div')),
                                      ));
           $this->getDisplayGroup('textsubmit')->setDecorators(array('FormElements',
                                      array('HtmlTag', array('tag' => 'div')),
                                      ));

     
    }


}

