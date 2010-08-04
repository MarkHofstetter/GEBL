<?php

class IndexController extends Zend_Controller_Action
{
    protected $hrModel;

    public function init()
    {
      //  $this->hrModel = new Application_Model_HRModel();


    }

    public function indexAction()
    {
      // echo $this->hrModel->getSysDate();
         $this->_helper->redirector('showallpoints','admin');
    }





}

