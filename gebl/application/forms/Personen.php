<?php
class Application_Form_Personen extends Zend_Form
{

    public function init()
    {
       $this->setMethod('post');

       $p_id = new Zend_Form_Element_Hidden('P_ID');
         $p_id->removeDecorator( 'Label' );

        $p_vorname = new Zend_Form_Element_Text('P_VORNAME');
         $p_vorname->setLabel('Vorname (optional): ')
              ->addValidator('Alpha', true, array('allowWhiteSpace' => true))
              ->addValidator('StringLength', false, array(0, 50))
              ->setAttrib('size','70');
			  
        $p_nachname = new Zend_Form_Element_Text('P_NACHNAME');
         $p_nachname->setLabel('Nachname (optional): ')
              ->addValidator('Alpha', true, array('allowWhiteSpace' => true))
              ->addValidator('StringLength', false, array(0, 50))
              ->setAttrib('size','70');			  
			  
        $p_plz = new Zend_Form_Element_Text('P_PLZ');
         $p_plz->setLabel('Plz (optional): ')
              ->addValidator('Alnum', true, array('allowWhiteSpace' => true))
              ->addValidator('StringLength', false, array(0, 10))
              ->setAttrib('size','70');			  			  
			  
        $p_ort = new Zend_Form_Element_Text('P_ORT');
         $p_ort->setLabel('Ort (optional): ')
              //->addValidator('Alpha', true, array('allowWhiteSpace' => true))
              ->addValidator('StringLength', false, array(0, 20))
              ->setAttrib('size','70');			  			  
			  
        $p_strasse = new Zend_Form_Element_Text('P_STRASSE');
         $p_strasse->setLabel('Strasse (optional): ')
              //->addValidator('Alpha', true, array('allowWhiteSpace' => true))
              ->addValidator('StringLength', false, array(0, 50))
              ->setAttrib('size','70');			  			  
			  
        $p_tel = new Zend_Form_Element_Text('P_TEL');
         $p_tel->setLabel('Telefon (optional): ')
              //->addValidator('Alnum', true, array('allowWhiteSpace' => true))
              ->addValidator('StringLength', false, array(0, 20))
              ->setAttrib('size','70');			  			  
			  
        $p_email = new Zend_Form_Element_Text('P_EMAIL');
         $p_email->setLabel('E-mail (optional): ')
              ->addValidator('EmailAddress', true, array('allowWhiteSpace' => true))
              ->addValidator('StringLength', false, array(0, 50))
              ->setAttrib('size','70');			  			  
			  
        $p_logname = new Zend_Form_Element_Text('P_LOGNAME');
         $p_logname->setLabel('* Login Name: ')
		      ->setRequired(true)
              ->addValidator('Db_NoRecordExists', true,
                      array('table' => 'PERSONEN','field' => 'P_LOGNAME',
                          'messages' =>
                          array(Zend_Validate_Db_NoRecordExists::ERROR_RECORD_FOUND =>
                              "Login Name '%value%' existiert bereits!")))
              ->addValidator('Alnum', true, array('allowWhiteSpace' => true))
              ->addValidator('StringLength', false, array(0, 20))
              ->setAttrib('size','70');			  			  
			  
        $p_passwort = new Zend_Form_Element_Password('P_PASSWORT');
         $p_passwort->setLabel('* Login Passwort: ')
		      ->setRequired(true)
              ->addValidator('StringLength', false, array(6, 20))
              ->setAttrib('size','70');

       $p_passwort_confirm = new Zend_Form_Element_Password('P_PASSWORT_CONFIRM');
         $p_passwort_confirm->setLabel('* Passwort wiederholen: ')
		      ->setRequired(true)
              ->addValidator('StringLength', false, array(6, 20))
              ->addValidator('Identical', false,
                      array('token' => 'P_PASSWORT', 'messages' =>
                      array(Zend_Validate_Identical::NOT_SAME =>
                          'Passwortwiederholung nicht korrekt!')))
              ->setAttrib('size','70');

 
         
         $typOptions = array(
                               '1' => 'Normal',
                               '2' => 'Experte',
                               '3' => 'Administrator'
                              );

         $p_typ = new Zend_Form_Element_Select('P_TYP');
         $p_typ->setLabel('* Benutzertyp: ')
		      ->setValue("1")
              ->setRequired(true)
              ->addValidator('Int')
              ->addValidator('Between',true,array(1,3))
              ->setMultiOptions($typOptions);

         
         $p_g_id = new Zend_Form_Element_Hidden('P_G_ID');
         $p_g_id->removeDecorator( 'Label' );

			  
		$p_text = new Zend_Form_Element_Textarea('P_TEXT');
         $p_text->setLabel('Kommentar (optional, maximal 1024 Zeichen):')
              ->setAttrib('rows','2')
              ->setAttrib('cols','60')
              ->addValidator('StringLength', false, array(0, 1024));

         $submit = new Zend_Form_Element_Submit('senden');
         $this->addElements(array($p_id, $p_vorname, $p_nachname, $p_plz,
             $p_ort, $p_strasse, $p_tel, $p_email, $p_logname,
             $p_passwort, $p_passwort_confirm, $p_typ, $p_g_id, $p_text, $submit));
  
    }
}
?>
