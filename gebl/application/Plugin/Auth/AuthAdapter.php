<?php
class Plugin_Auth_AuthAdapter extends Zend_Auth_Adapter_DbTable
{
  public function __construct()
  {
  $registry = Zend_Registry::getInstance();
  parent::__construct($registry->dbAdapter);

  $this->setTableName('PERSONEN');
  $this->setIdentityColumn('P_LOGNAME');
  $this->setCredentialColumn('P_PASSWORT');
  //$this->setCredentialTreatment('SHA1(?)');
  }
}


?>
