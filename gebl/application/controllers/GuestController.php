<?php

class GuestController extends Zend_Controller_Action {

    public function init() {
        //Context Switch for XML
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch->addActionContext('listallbrutgeodaten', 'xml')
                ->initContext();
    }

    public function indexAction() {
        $this->_helper->redirector('showallbrutstaetten', 'guest');
    }

    public function showallbrutstaettenAction() {
        $lat = 0;
        $lon = 0;
        $zoom = 12;

        if ($this->getRequest()->isGet()) {
            $lat = (float) $this->_getParam('lat', 0);
            $lon = (float) $this->_getParam('lon', 0);
            $zoom = (float) $this->_getParam('zoom', 0);
        }
        $this->view->lat = $lat;
        $this->view->lon = $lon;
        $this->view->zoom = $zoom;
    }

    public function listallbrutgeodatenAction() {
        //$pointsModel = new Application_Model_DbTable_Geodaten();
        //$this->view->dom = $pointsModel->listBrutGeodatenXML();
        $pointsModel = new Application_Model_GeodatenBrutstaetten();
        $this->view->dom = $pointsModel->listBrutGeodatenXML();
    }

    public function addbrutstaetteAction() {

        $lat = 0;
        $lon = 0;
        $zoom = 12;

        if ($this->getRequest()->isGet()) {
            $lat = $this->_getParam('lat', 0);
            $lon = $this->_getParam('lon', 0);
            $zoom = (float) $this->_getParam('zoom', 0);
        }else{
            $lat = 0;
            $lon = 0;
            $zoom = 12;
        }

        $form = new Application_Form_Brutstaette();

        $form->senden->setLabel('Melden!');

        // Entferne Felder die nicht für Guest bestimmt:
        $form->B_GEWAESSER_ART->setAttribs(array('style' => 'display:none;'))
                              ->removeDecorator('label');
        $form->B_BEK_ART->setAttribs(array('style' => 'display:none;'))
                              ->removeDecorator('label');
        $form->B_ZUGANG->setAttribs(array('style' => 'display:none;'))
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

                
                $b_p_id = null;
                $checked = 0;
                

                $geodaten = new Application_Model_DbTable_Geodaten();

                $b_g_id = $geodaten->addGeodaten($name, $typ, $lat, $lon);

                $brutstaetten = new Application_Model_DbTable_Brutstaetten();

                $brutstaetten->addBrutstaette($b_groesse, $b_gew_art,
                        $b_zugang, $b_bek_art, $b_text, $b_kontakt, $b_g_id, $b_p_id, $checked);
                $this->_helper->redirector('showallbrutstaetten', 'guest',
                        null, array('lat' => $lat, 'lon' => $lon, 'zoom' => $zoom));
            }
            $lat = $form->getValue('G_LAT');
            $lon = $form->getValue('G_LON');
            $zoom = $form->getValue('ZOOM');
            $this->view->lat = $lat;
            $this->view->lon = $lon;
            $this->view->zoom = $zoom;
        }
    }

}

