<?php

class Plugin_Auth_AccessControl extends Zend_Controller_Plugin_Abstract {

    public function __construct(Zend_Auth $auth, Zend_Acl $acl) {
        $this->_auth = $auth;
        $this->_acl = $acl;
    }

    public function routeStartup(Zend_Controller_Request_Abstract $request) {

        if (!$this->_auth->hasIdentity()
                && null !== $request->getPost('username')
                && null !== $request->getPost('password')) {


                // POST-Daten bereinigen
                $filter = new Zend_Filter_StripTags();
                $username = $filter->filter($request->getPost('username'));
                $password = $filter->filter($request->getPost('password'));
                
                if (empty($username)) {
                    $message = 'Bitte Benutzernamen angeben.';
                    
                } elseif (empty($password)) {
                    $message = 'Bitte Passwort angeben.';
                } else {
                    $authAdapter = new Plugin_Auth_AuthAdapter();
                    $authAdapter->setIdentity($username);
                    $authAdapter->setCredential($password);
                    $result = $this->_auth->authenticate($authAdapter);
                    if (!$result->isValid()) {
                        //$messages = $result->getMessages();
                        //$message = $messages[0];
                        $message = "Ungültige Login Daten!";
                    } else {
                        $storage = $this->_auth->getStorage();
                        // die gesamte Tabellenzeile in der Session speichern,
                        // wobei das Passwort unterdrückt wird
                        $storage->write($authAdapter->getResultRowObject(null, 'password'));

                        if ($this->_auth->hasIdentity() && is_object($this->_auth->getIdentity())) {
                            $role = $this->_auth->getIdentity()->P_TYP;
                        } else {
                            $role = '1';
                        }
                        $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');


                        $request->setModuleName('default');
                        switch ($role) {
                            case '1':
                                $redirector->gotoUrl('/guest/index');
                                break;

                            case '2':
                                $redirector->gotoUrl('/guest/index');
                                break;

                            case '3':
                                $redirector->gotoUrl('/admin/index');
                                break;
                        }
                        $request->setControllerName($contr);
                        $request->setActionName('index');
                    }

                    
                }
                $registry = Zend_Registry::getInstance();
                $view = $registry->view;
                if (isset($message)) {
                    //var_dump($message);
                    $view->message = $message;
                }
            }
        
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        if ($this->_auth->hasIdentity() && is_object($this->_auth->getIdentity())) {
            $role = $this->_auth->getIdentity()->P_TYP;
        } else {
            $role = '1';
        }

        $module = $request->getControllerName();
        // Ressourcen = Controller -> kann hier geändert werden!
        $resource = $module;

        if (!$this->_acl->has($resource)) {
            $resource = null;
        }
        //var_dump($role);
        //var_dump($resource);
        //var_dump ($this->_acl->isAllowed($role, $resource));

        if (!$this->_acl->isAllowed($role, $resource)) {
            if ($this->_auth->hasIdentity()) {
                // angemeldet, aber keine Rechte -> Fehler!
               
                $request->setModuleName('default');
                $request->setControllerName('error');
                $request->setActionName('noaccess');
            } else {
                //nicht angemeldet -> Login
                $request->setModuleName('default');
                $request->setControllerName('index');
                $request->setActionName('login');
            }
        } else {
            //angemeldet
        }
    }

}

?>
