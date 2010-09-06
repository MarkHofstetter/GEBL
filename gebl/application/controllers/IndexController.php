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
        $this->_helper->redirector('index','guest');
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
            $storage  = $auth->getStorage();
            // die gesamte Tabellenzeile in der Session speichern,
            // wobei das Passwort unterdrückt wird
            $storage->write($authAdapter->getResultRowObject(null, 'password'));
            $p_g_id = $auth->getIdentity()->P_G_ID;
            $geodatenModel = new Application_Model_DbTable_Geodaten();
            $personengeodaten = $geodatenModel->getPersonenGeodaten($p_g_id);
            $lat = $personengeodaten['G_LAT'];
            $lon = $personengeodaten['G_LON'];
            $zoom= 14;
            $this->_helper->redirector('showallpoints','admin', null, array('lat' => $lat, 'lon' => $lon, 'zoom' => $zoom));
        }
        else{
            $this->_flashMessenger->addMessage('Name oder Passwort nicht korrekt!');
            
            $this->_helper->redirector('login','index');
        }}
      }}

    public function logoutAction() {
        Zend_Auth::getInstance()->clearIdentity();
         $this->_helper->redirector('index','guest');
    }



}

