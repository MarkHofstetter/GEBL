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

        if ($this->getRequest()->isGet()) {
            $lat = (float) $this->_getParam('lat', 0);
            $lon = (float) $this->_getParam('lon', 0);
        }
        $this->view->lat = $lat;
        $this->view->lon = $lon;
    }

    public function listallbrutgeodatenAction() {
        $pointsModel = new Application_Model_DbTable_Geodaten();
        $this->view->dom = $pointsModel->listBrutGeodatenXML();
    }

    public function addbrutstaetteAction() {

        $lat = 0;
        $lon = 0;
        if ($this->getRequest()->isGet()) {
            $lat = $this->_getParam('lat', 0);
            $lon = $this->_getParam('lon', 0);
        }

        $form = new Application_Form_Brutstaette();

        $form->senden->setLabel('Hinzufügen');
        $this->view->form = $form;
        $this->view->lat = $lat;
        $this->view->lon = $lon;


        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $typ = 3;
                $name = $form->getValue('G_NAME');
                $lat = $form->getValue('G_LAT');
                $lon = $form->getValue('G_LON');


                $b_name = $form->getValue('B_NAME');
                $b_groesse = $form->getValue('B_GROESSE');
                $b_gew_art = $form->getValue('B_GEWAESSER_ART');
                $b_zugang = $form->getValue('B_ZUGANG');
                $b_bek_art = $form->getValue('B_BEK_ART');
                $b_text = $form->getValue('B_TEXT');

                
                $b_p_id = null;
                $checked = 0;
                

                $geodaten = new Application_Model_DbTable_Geodaten();

                $b_g_id = $geodaten->addGeodaten($typ, $lat, $lon, $checked);



                $brutstaetten = new Application_Model_DbTable_Brutstaetten();

                $brutstaetten->addBrutstaette($b_name, $b_groesse, $b_gew_art,
                        $b_zugang, $b_bek_art, $b_text, $b_g_id, $b_p_id);
                $this->_helper->redirector('showallbrutstaetten', 'guest',
                        null, array('lat' => $lat, 'lon' => $lon));
            }
            $lat = $form->getValue('G_LAT');
            $lon = $form->getValue('G_LON');
            $this->view->lat = $lat;
            $this->view->lon = $lon;
        }
    }

}

