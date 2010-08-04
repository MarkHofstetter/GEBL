<?php

class AdminController extends Zend_Controller_Action
{

    public function init()
    {
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch->addActionContext('listallpoints', 'xml')
                      ->initContext();
    }

    public function indexAction()
    {
        // action body
    }

    /*
     * Add a Point by selecting coordiantes in map
     */
    public function addPointAction()
    {
        $form = new Application_Form_Point();
                $form->senden->setLabel('Add');
                $this->view->form = $form;
                
        
                if ($this->getRequest()->isPost()) {
                    $formData = $this->getRequest()->getPost();
                    if ($form->isValid($formData)) {
                        $cat = $form->getValue('G_P_CAT');
                        $name = $form->getValue('G_P_NAME');
                        $lat = $form->getValue('G_P_LAT');
                        $lng = $form->getValue('G_P_LNG');
        
        
                        $points = new Application_Model_DbTable_GooglePoints();
                        $points->addPoint($cat, $name, $lat, $lng);
        
                        $this->_helper->redirector('showallpoints','admin');
                    }
    }
    }

   /**
    * Generate XML File for all Points
    */
    public function listallpointsAction()
    {
        $pointsModel = new Application_Model_DbTable_GooglePoints();
        $points = $pointsModel->fetchAll();

        $this->view->allPoints = $points;
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
            $points = new Application_Model_DbTable_GooglePoints();
            $points->deletepoint($id);
            //$this->_flashMessenger->addMessage('Löschen Erfolgreich!');
            $this->_helper->redirector('showallpoints','admin');
        }
    }

}



