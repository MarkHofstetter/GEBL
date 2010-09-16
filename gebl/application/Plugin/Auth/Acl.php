<?php
class Plugin_Auth_Acl extends Zend_Acl
{
  public function __construct()
  {
   // RESSOURCES
   $this->add(new Zend_Acl_Resource('admin'));
   $this->add(new Zend_Acl_Resource('member'));
   $this->add(new Zend_Acl_Resource('guest'));
   $this->addRole(new Zend_Acl_Role('1'));
   $this->addRole(new Zend_Acl_Role('2'), '1');
   $this->addRole(new Zend_Acl_Role('3'), '2');
   $this->allow(null, null);
   $this->deny('1', 'member');
   $this->deny('1', 'admin');
   $this->allow('3','admin');
   $this->allow('3', 'member');
  }
}


?>
