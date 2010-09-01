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
         $zoom->removeDecorator( 'Label' );
         //store zoom for redraw in case of wrong input

        $aktionen = new Application_Model_AktionenAktionstyp;
        $date = $aktionen->getSysDate();
        $a_datum = new Zend_Form_Element('A_DATUM');
        $a_datum->setLabel('* Datum (Format TT.MM.JJ): ')
              ->setRequired(true)
              ->addValidator('Date',false, array('format'=>'dd.MM.yy'))
              ->setAttrib('size','8')
              ->setValue($date);

         $aktionstyp = new Application_Model_DbTable_Aktionstyp;
         $aktionenList = $aktionstyp->getAktionstypList();
         $a_typ = new Zend_Form_Element_Select('A_TYP');
         $a_typ->setLabel('* Typ: ')
              ->setRequired(true)
              ->addMultiOptions($aktionenList);
         
        $a_text = new Zend_Form_Element_Textarea('A_TEXT');
        $a_text->setLabel('Kommentar (optional, maximal 1024 Zeichen):')
              //->addValidator('Alnum', true, array('allowWhiteSpace' => true))
              ->setAttrib('rows','3')
              ->setAttrib('cols','40')
              ->addValidator('StringLength', false, array(0, 1024));
        
        $submit = new Zend_Form_Element_Submit('senden');

        $this->addElements(array($g_id, $zoom, $a_datum, $a_typ, $a_text, $submit));

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

