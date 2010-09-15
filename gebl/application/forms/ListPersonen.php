<?php
class Application_Form_ListPersonen extends Zend_Form
{

    public function init()
    {
       $this->setMethod('post');


        $id = new Zend_Form_Element_Hidden('P_ID');
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
			  	  			  			  
		$p_typ = new Zend_Form_Element('P_TYP');
         $p_typ->setLabel('* Benutzertyp (1 Normal, 2 Experte, 3 Administrator) : ')
              ->setRequired(true)
              ->addValidator('Int')
              ->addValidator('Between',true,array(1,3));

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

         $submit = new Zend_Form_Element_Submit('senden');
         $this->addElements(array($id, $p_logname, $p_typ, $p_vorname, $p_nachname,
               $submit));
  
    }
}
?>
