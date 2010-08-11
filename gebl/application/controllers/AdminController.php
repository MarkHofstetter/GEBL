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
  
        public function addbrutstaetteAction()
    {
        $form = new Application_Form_Brutstaette();
                $form->senden->setLabel('Hinzufügen');
                $this->view->form = $form;


                if ($this->getRequest()->isPost()) {
                    $formData = $this->getRequest()->getPost();
                    if ($form->isValid($formData)) {
                        $typ = 3;
                        $name = $form->getValue('G_NAME');
                        $lat = $form->getValue('G_LAT');
                        $lon = $form->getValue('G_LON');

                        $b_name = $form->getValue('B_NAME');
                        $b_groesse = $form->getValue('B_GROESSE');
                        $b_gewaesser_art = $form->getValue('B_GEWAESSER_ART');
                        $b_zugang = $form->getValue('B_ZUGANG');
                        $b_bek_art = $form->getValue('B_BEK_ART');
                        $b_text = $form->getValue('B_TEXT');

                        $points = new Application_Model_DbTable_Geodaten();
                        $pointdata = array(
                              'G_TYP' => $typ,
                              'G_NAME' => $name,
                              'G_LAT' => $lat,
                              'G_LON' => $lon
                              );

                        $b_g_id = $points->insert($pointdata);

                        $brutstaetten = new Application_Model_DbTable_Brutstaetten();
                        $brutdata = array(
                              'B_NAME' => $b_name,
                              'B_GROESSE' => $b_groesse,
                              'B_GEWAESSER_ART' => $b_gewaesser_art,
                              'B_ZUGANG' => $b_zugang,
                              'B_BEK_ART' => $b_bek_art,
                              'B_TEXT' => $b_text,
                              'B_G_ID' => $b_g_id
                             );

                        $brutstaetten->insert($brutdata);
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
            if ($brut['B_ID'] <> NULL) {
                $aktionenModel = new Application_Model_DbTable_Aktionen();
                $aktionen = $aktionenModel->fetchAll('A_B_ID = ' . $brut['B_ID']);
            }

           }
        $this->view->brutst = $brut;
        $this->view->akt= $aktionen;

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



