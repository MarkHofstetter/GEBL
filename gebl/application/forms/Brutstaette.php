<?php

class Application_Form_Brutstaette extends Zend_Form
{

    public function init()
    {
       $this->setMethod('post');

       $zoom = new Zend_Form_Element_Hidden('ZOOM');
         $zoom->removeDecorator( 'Label' );
         //store zoom for redraw in case of wrong input
       $g_id = new Zend_Form_Element_Hidden('G_ID');
         $g_id->removeDecorator( 'Label' );
        $b_checked = new Zend_Form_Element_Hidden('B_CHECKED');
          $b_checked ->removeDecorator( 'Label' );
        $g_name = new Zend_Form_Element_Text('G_NAME');
         $g_name->setLabel('* Name: ')
              ->addValidator('Alnum', true, array('allowWhiteSpace' => true))
              ->setRequired(true)
              ->addValidator('StringLength', false, array(0, 50))
              ->setAttrib('size','50');
        $lat = new Zend_Form_Element('G_LAT');
         $lat->setLabel('* Breitengrad (Click auf Karte oder Eingabe in Dezimalgrad):')
              ->setRequired(true)
             //->addValidator('Float')
              ->addValidator('Between',true,array(46,49));
              //->setAttrib('disabled', 'true');
        $lon = new Zend_Form_Element('G_LON');
         $lon->setLabel('* Längengrad (Click auf Karte oder Eingabe in Dezimalgrad):')
               ->setRequired(true)
               //->addValidator('Float')
               ->addValidator('Between',true,array(14,18));
                //->setAttrib('disabled', 'true');
        $groesse = new Zend_Form_Element('B_GROESSE');
         $groesse->setLabel('* Geschätzte Größe in m² zwischen 1 und 100000 : ')
              ->setRequired(true)
              ->addValidator('Int')
              ->addValidator('Between',true,array(0,100000));
        $gewaesser_art = new Zend_Form_Element_Text('B_GEWAESSER_ART');
         $gewaesser_art->setLabel('Gewässerart: ')
              ->addValidator('Alnum', true, array('allowWhiteSpace' => true))
              ->addValidator('StringLength', false, array(0, 50))
              ->setAttrib('size','50');;
        $zugang = new Zend_Form_Element_Text('B_ZUGANG');
         $zugang->setLabel('Zugang: ')
              ->addValidator('Alnum', true, array('allowWhiteSpace' => true))
              ->addValidator('StringLength', false, array(0, 100))
              ->setAttrib('size','50');;
        $bek_art = new Zend_Form_Element_Text('B_BEK_ART');
         $bek_art->setLabel('Bekämpfungsart: ')
              ->addValidator('Alnum', true, array('allowWhiteSpace' => true))
              ->setAttrib('size','50');;
        $text = new Zend_Form_Element_Textarea('B_TEXT');
         $text->setLabel('Text (maximal 1024 Zeichen):')
              //->addValidator('Alnum', true, array('allowWhiteSpace' => true))
              ->setAttrib('rows','3')
              ->setAttrib('cols','40')
              ->addValidator('StringLength', false, array(0, 1024));
        $kontaktdaten = new Zend_Form_Element_Textarea('B_KONTAKTDATEN');
         $kontaktdaten->setLabel('Kontaktdaten (maximal 256 Zeichen):')
              //->addValidator('Alnum', true, array('allowWhiteSpace' => true))
              ->setAttrib('rows','3')
              ->setAttrib('cols','40')
              ->addValidator('StringLength', false, array(0, 256));

        $submit = new Zend_Form_Element_Submit('senden');
        $this->addElements(array($zoom, $g_id, $b_checked, $g_name, $lat, $lon,
         $groesse, $gewaesser_art, $zugang, $bek_art, $text, $kontaktdaten ,$submit));

      // remove decorators fron hidden fields
  /*    $this->addDisplayGroup(
            array('G_ID', 'B_CHECKED'),
             'hiddenfields',
            array('disableLoadDefaultDecorators' => true)
            );
*/
 /*       //Layout
        $this->addDisplayGroup(array(
                    'G_NAME',
                    'G_LAT',
                    'G_LON',
                    ),'geopoint',array('legend' => 'Daten zum Punkt'));
        $contact = $this->getDisplayGroup('geopoint');
        $contact->setDecorators(array(
                    'FormElements',
                    'Fieldset'
                   // array('HtmlTag',array('tag'=>'div','openOnly'=>true))
        ));
        $this->addDisplayGroup(array(
                    'B_GROESSE',
                    'B_GEWAESSER_ART',
                    'B_ZUGANG',
                    'B_BEK_ART',
                    'B_TEXT',
                    'B_KONTAKTDATEN'
        ),'brutstaette',array('legend' => 'Daten zur Brutstaette'));
        $pass = $this->getDisplayGroup('brutstaette');
        $pass->setDecorators(array(
                'FormElements',
                'Fieldset',
                //array('HtmlTag',array('style'=>''))
               ));
        $this->addDisplayGroup(array(
                    'senden',
                  ),'submitbutton',array('legend' => 'Daten Abschicken'));
        $pass = $this->getDisplayGroup('submitbutton');
        $pass->setDecorators(array(
                'FormElements',
                array('HtmlTag',array('tag'=>'div','closeOnly'=>true)
        )));


        $this->setDecorators(array(
                'FormElements',
                array('HtmlTag',array('tag'=>'div','style'=>'width:379px')),
                'Form'
        ));
*/
    }


}

