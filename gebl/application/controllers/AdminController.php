<?php

class AdminController extends Zend_Controller_Action
{

  // protected $_flashMessenger;

    public function init()
    {
        //Context Switch for XML
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch->addActionContext('listallpoints', 'xml')
                      ->initContext();
        $contextSwitch->addActionContext('listonepoint', 'xml')
                      ->initContext();
        $contextSwitch->addActionContext('listonebrutstaette', 'xml')
                      ->initContext();

        //Authentification
        $auth = Zend_Auth::getInstance();
        if(!$auth->hasIdentity()){
            $this->_helper->redirector('login', 'index');
        }

        //SET NLS_NUMERIC_CHARACTERS to "." for Database
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->query("alter session set NLS_NUMERIC_CHARACTERS = '. '");
        

        //FlashMessenger
    //    $this->_flashMessenger = $this->_helper->getHelper('flashMessenger');
    }

    public function indexAction()
    {
         $this->_helper->redirector('showallpoints','admin');
        //$this->_helper->redirector('login', 'index');
    }

    /*
     * Add a Point by selecting coordiantes in map
     */
    public function addPointAction()
    {
        $form = new Application_Form_Geopoint();
                $form->senden->setLabel('Hinzufügen');
                $this->view->form = $form;
                
        
                if ($this->getRequest()->isPost()) {
                    $formData = $this->getRequest()->getPost();
                    if ($form->isValid($formData)) {
                        $typ = $form->getValue('G_TYP');
                        $name = $form->getValue('G_NAME');
                        $lat = $form->getValue('G_LAT');
                        $lon = $form->getValue('G_LON');
        
        
                        $points = new Application_Model_DbTable_Geodaten();
                        
                        $points->addPoint($typ, $name, $lat, $lon);
        
                        $this->_helper->redirector('showallpoints','admin');
                    }
    }
    }

   /**
    * Generate XML File for all Points
    */
    public function listallpointsAction()
    {
        $pointsModel = new Application_Model_DbTable_Geodaten();
        $points = $pointsModel->fetchAll();

        $this->view->allPoints = $points;
    }

    public function listonepointAction()
    {
        if($this->getRequest()->isGet()){
            $id = $this->_getParam('id',0);
            $pointsModel = new Application_Model_DbTable_Geodaten();
            $points = $pointsModel->find($id);
            
        }
        $this->view->allPoints = $points;
    }

      public function listonebrutstaetteAction()
    {
        if($this->getRequest()->isGet()){
            $g_id = $this->_getParam('g_id',0);
            $g_id = (int)$g_id;
            $brutModel = new Application_Model_DbTable_Brutstaetten();
            //$select = $brutModel->select()->where('B_G_ID = ?', $g_id);
            //$brut = $brutModel->fetchRow($select);
            $brut = $brutModel->fetchRow('B_G_ID = ' . $g_id);
           }
        $this->view->brutst = $brut;
    }

    /*
     * Show all Points in Map
     */
    public function showallpointsAction()
    {
       
    }


public function deletepointAction()
    {
        if($this->getRequest()->isGet()){
            $id = $this->_getParam('id',0);
            $points = new Application_Model_DbTable_Geodaten();
            $points->deletepoint($id);
            //$this->_flashMessenger->addMessage('Löschen Erfolgreich!');
            $this->_helper->redirector('showallpoints','admin');
        }
    }

}



