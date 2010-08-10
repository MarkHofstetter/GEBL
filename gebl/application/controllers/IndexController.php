<?php

class IndexController extends Zend_Controller_Action
{
    protected $hrModel;
    protected $_flashMessenger;

    public function init()
    {
      //  $this->hrModel = new Application_Model_HRModel();


        //FlashMessenger
        $this->_flashMessenger = $this->_helper->getHelper('flashMessenger');

    }

    public function indexAction()
    {
      // echo $this->hrModel->getSysDate();
       //$this->_helper->redirector('showallpoints','admin');
        $this->_helper->redirector('login','index');
    }


public function loginAction()
    {

       
        $form = new Application_Form_Auth();
        $this->view->form = $form;
        $this->view->message = $this->_flashMessenger->getMessages();
        if ($this->getRequest()->isPost()){
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {


        $authAdapter = new Zend_Auth_Adapter_DbTable(
                NULL,
                'PERSONEN',
                'P_LOGNAME',
                'P_PASSWORT'
                );
        $authAdapter->setCredential($this->_getParam('password'))
                ->setIdentity($this->_getParam('username'));

        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($authAdapter);

        if($result->isValid()) {
            $this->_helper->redirector('index','admin');
        }
        else{
            $this->_flashMessenger->addMessage('Name oder Passwort nicht korrekt!');
            
            $this->_helper->redirector('login','index');
        }}
      }}

    public function logoutAction() {
        Zend_Auth::getInstance()->clearIdentity();
         $this->_helper->redirector('login','index');
    }



}

