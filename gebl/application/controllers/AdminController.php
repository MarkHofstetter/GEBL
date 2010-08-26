<?php

class AdminController extends Zend_Controller_Action {

   

    protected $_auth;

    public function init() {
                
        //Context Switch for XML
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch->addActionContext('listallpoints', 'xml')
                ->initContext();
        $contextSwitch->addActionContext('listonepoint', 'xml')
                ->initContext();
        $contextSwitch->addActionContext('listonebrutstaette', 'xml')
                ->initContext();

        //Authentification
        $this->_auth = Zend_Auth::getInstance();
        if (!$this->_auth->hasIdentity()) {
            $this->_helper->redirector('login', 'index');
        }


        /*    //SET NLS_NUMERIC_CHARACTERS to "." for Database moved to bootstrap
          $this->db = Zend_Db_Table::getDefaultAdapter();
          $this->db->query("alter session set NLS_NUMERIC_CHARACTERS = '. '");

         */
        //FlashMessenger
        //    $this->_flashMessenger = $this->_helper->getHelper('flashMessenger');
    }

    public function indexAction() {
        $this->_helper->redirector('showallpoints', 'admin');
        //$this->_helper->redirector('login', 'index');
    }

    /*
     * Add a Point by selecting coordiantes in map
     */

    public function addPointAction() {
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


                $this->_helper->redirector('showallpoints', 'admin',
                        null, array('lat' => $lat, 'lon' => $lon));
            }
        }
    }

    public function addbrutstaetteAction() {

        $lat = 0;
        $lon = 0;
        $zoom = 0;
        if ($this->getRequest()->isGet()) {
            $lat = $this->_getParam('lat', 0);
            $lon = $this->_getParam('lon', 0);
            $zoom = $this->_getParam('zoom', 0);
        }

        $form = new Application_Form_Brutstaette();
        $form->senden->setLabel('Hinzufügen');
		// Entferne Felder die nicht für Admin bestimmt:
        $form->B_KONTAKTDATEN->setAttribs(array('style' => 'display:none;'))
                              ->removeDecorator('label');
							  
        $this->view->form = $form;
        $this->view->lat = $lat;
        $this->view->lon = $lon;
        $this->view->zoom = $zoom;


        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $typ = 3;
                $name = $form->getValue('G_NAME');
                $lat = $form->getValue('G_LAT');
                $lon = $form->getValue('G_LON');

                $b_groesse = $form->getValue('B_GROESSE');
                $b_gew_art = $form->getValue('B_GEWAESSER_ART');
                $b_zugang = $form->getValue('B_ZUGANG');
                $b_bek_art = $form->getValue('B_BEK_ART');
                $b_text = $form->getValue('B_TEXT');
                $b_kontakt = $form->getValue('B_KONTAKTDATEN');

                $zoom = $form->getValue('ZOOM');

                if ($this->_auth->hasIdentity() && is_object($this->_auth->getIdentity())) {
                    $b_p_id = $this->_auth->getIdentity()->P_ID;
                    $checked = 1;
                } else {
                    $b_p_id = null;
                    $checked = 0;
                }

                $geodaten = new Application_Model_DbTable_Geodaten();

                $b_g_id = $geodaten->addGeodaten($name, $typ, $lat, $lon);



                $brutstaetten = new Application_Model_DbTable_Brutstaetten();

                $brutstaetten->addBrutstaette($b_groesse, $b_gew_art,
                        $b_zugang, $b_bek_art, $b_text, $b_kontakt,$b_g_id, $b_p_id, $checked);

                //$this->_flashMessenger->addMessage('Neue Brutstätte gespeichert');
                $this->_helper->redirector('showallpoints', 'admin',
                        null, array('lat' => $lat, 'lon' => $lon, 'zoom' => $zoom ));
            }
            $lat = $form->getValue('G_LAT');
            $lon = $form->getValue('G_LON');
            $zoom = $form->getValue('ZOOM');
            $this->view->lat = $lat;
            $this->view->lon = $lon;
            $this->view->zoom = $zoom;
            //$this->_flashMessenger->addMessage('Ungültige Daten! Bitte überprüfen Sie Ihre Eingaben!');
        }
    }

    public function editbrutstaetteAction() {
        $id = 0;
        $lat = 0;
        $lon = 0;
        $zoom = 0;

        $form = new Application_Form_Brutstaette();
        $form->senden->setLabel('Ändern');
        $form->setAction('/admin/editbrutstaette');
        $this->view->form = $form;


        if ($this->getRequest()->isPost()) {
               $formData = $this->getRequest()->getPost();
                if ($form->isValid($formData)) {
                    $typ = 3;
                    $id = $form->getValue('G_ID');
                    $name = $form->getValue('G_NAME');
                    $lat = $form->getValue('G_LAT');
                    $lon = $form->getValue('G_LON');
                    $b_groesse = $form->getValue('B_GROESSE');
                    $b_gew_art = $form->getValue('B_GEWAESSER_ART');
                    $b_zugang = $form->getValue('B_ZUGANG');
                    $b_bek_art = $form->getValue('B_BEK_ART');
                    $b_text = $form->getValue('B_TEXT');
                    $b_kontakt = $form->getValue('B_KONTAKTDATEN');
                    $checked = $form->getValue('B_CHECKED');

                    $zoom = $form->getValue('ZOOM');

                    if ($this->_auth->hasIdentity() && is_object($this->_auth->getIdentity())) {
                        $b_p_id = $this->_auth->getIdentity()->P_ID;
                        
                    } else {
                        $b_p_id = null;
                        
                    }

                    $geodaten = new Application_Model_DbTable_Geodaten();
                    $geodaten->updateGeodaten($id, $name, $typ, $lat, $lon);

                    $b_g_id = $id;
                    $brutstaetten = new Application_Model_DbTable_Brutstaetten();
                    $brutstaetten->updateBrutstaette($b_groesse, $b_gew_art,
                            $b_zugang, $b_bek_art, $b_text, $b_kontakt,$b_g_id, $b_p_id, $checked);
                    $this->_helper->redirector('showallpoints', 'admin',
                            null, array('lat' => $lat, 'lon' => $lon, 'zoom' => $zoom));
                } else {
                    $lat = $form->getValue('G_LAT');
                    $lon = $form->getValue('G_LON');
                    $id = $form->getValue('G_ID');
                    $zoom = $form->getValue('ZOOM');
                    $this->view->lat = $lat;
                    $this->view->lon = $lon;
                    $this->view->zoom = $zoom;
                    $this->view->id = $id;
                    //$form->populate($formData);
                }
            } else {
                $id = $this->_getParam('g_id', 0);
                $lat = $this->_getParam('lat', 0);
                $lon = $this->_getParam('lon', 0);
                $zoom = $this->_getParam('zoom', 0);
                $this->view->lat = $lat;
                $this->view->lon = $lon;
                $this->view->zoom = $zoom;
                $this->view->id = $id;
                if ($id > 0) {
                    $geodatenModel = new Application_Model_DbTable_Geodaten();
                    $this->view->form->populate($geodatenModel->
                                    fetchRow('G_ID=' . $id)->toArray());
                    $brutModel = new Application_Model_DbTable_Brutstaetten();
                    $this->view->form->populate($brutModel->
                                    fetchRow('B_G_ID=' . $id)->toArray());
               }
            }
          }

     /**
     * Generate XML File for all Points
     */
    public function listallpointsAction() {
        //$pointsModel = new Application_Model_DbTable_Geodaten();
        //$this->view->dom = $pointsModel->listAllGeodatenXML();
        $pointsModel = new Application_Model_GeodatenBrutstaetten();
        $this->view->dom = $pointsModel->listAllGeodatenAndBrutCheckedXML();
    }

    public function listonepointAction() {
        if ($this->getRequest()->isGet()) {
            $id = $this->_getParam('id', 0);
            $pointsModel = new Application_Model_DbTable_Geodaten();
            $points = $pointsModel->find($id);
        }
        $this->view->allPoints = $points;
    }

    public function listonebrutstaetteAction() {
        if ($this->getRequest()->isGet()) {
            $g_id = $this->_getParam('g_id', 0);
            $g_id = (int) $g_id;
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
        $this->view->akt = $aktionen;
    }

    public function setbrutcheckedAction() {
        $lat = 0;
        $lon = 0;
        $zoom = 0;

        if ($this->getRequest()->isGet()) {
            $g_id = $this->_getParam('g_id', 0);
            $g_id = (int) $g_id;
            $lat = $this->_getParam('lat', 0);
            $lon = $this->_getParam('lon', 0);
            $zoom = $this->_getParam('zoom', 0);

            $geodatenModel = new Application_Model_DbTable_Brutstaetten();
            $geodatenModel->setChecked($g_id);
        }
        $this->_helper->redirector('showallpoints', 'admin',
                null, array('lat' => $lat, 'lon' => $lon, 'zoom' => $zoom));
    }

    /*
     * Show all Points in Map
     */

    public function showallpointsAction() {
        $lat = 0;
        $lon = 0;
        $zoom = 0;

        if ($this->getRequest()->isGet()) {
            $lat = (float) $this->_getParam('lat', 0);
            $lon = (float) $this->_getParam('lon', 0);
            $zoom = (float) $this->_getParam('zoom', 0);
        }
        $this->view->lat = $lat;
        $this->view->lon = $lon;
        $this->view->zoom = $zoom;
    }

    public function deletepointAction() {
        if ($this->getRequest()->isGet()) {
            $id = $this->_getParam('id', 0);
            $lat = $this->_getParam('lat', 0);
            $lon = $this->_getParam('lon', 0);
            $zoom = $this->_getParam('zoom', 0);
            $points = new Application_Model_DbTable_Geodaten();
            $points->deleteGeodaten($id);
            //$this->_flashMessenger->addMessage('Löschen Erfolgreich!');
            $this->_helper->redirector('showallpoints', 'admin',
                    null, array('lat' => $lat, 'lon' => $lon, 'zoom' => $zoom));
        }
    }

}

