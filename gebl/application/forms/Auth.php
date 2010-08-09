<?php

class Application_Form_Auth extends Zend_Form
{

    public function init()
    {
        $this->setAction('/index/login');
        $this->setMethod('post');
        $user = new Zend_Form_Element_Text('username');
        $user->setLabel('Name: ')
                ->setRequired(true);
        $pass = new Zend_Form_Element_Password('password');
        $pass->setLabel('Passwort: ')
                ->setRequired(true);

        $submit = new Zend_Form_Element_Submit('senden');

        $this->addElements(array($user, $pass, $submit));
    }


}

