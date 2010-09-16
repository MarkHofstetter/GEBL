<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    public function _initCache() {
        $frontendOptions = array('automatic_serialization' => true);
        $backendOptions = array('cache_dir' => '../cache/');
        $dbCache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
        Zend_Db_Table_Abstract::setDefaultMetadataCache($dbCache);
    }

    protected function _initViewHelpers() {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html:charset=utf-8');
        $view->headLink()->appendStylesheet($view->BaseUrl('/css/screen.css'));
        $view->doctype('XHTML1_STRICT');
        $view->headTitle()->setSeparator(' - ');
        $view->headTitle('GEBL-Karte');
        Zend_Registry::set('view', $view);

    }

    protected function _initLanguage() {
        $locale = new Zend_Locale('de_AT');
        $translator = new Zend_Translate(
                        'array',
                        APPLICATION_PATH . '/../resources/languages',
                        'de',
                        array('scan' => Zend_Translate::LOCALE_DIRECTORY)
        );
        Zend_Validate_Abstract::setDefaultTranslator($translator);
        Zend_Locale::setDefault($locale);
    }

    protected function _initDBSettings() {
        //SET NLS_NUMERIC_CHARACTERS to "." for Database
        $resource = $this->getPluginResource('db');
        $db = $resource->getDbAdapter();
        $db->query("alter session set NLS_NUMERIC_CHARACTERS = '. '");
        $db->query("alter session set NLS_DATE_FORMAT = 'DD.MM.YY'");
        Zend_Registry::set('dbAdapter', $db);
    }

    protected function _initAuth() {
        $this->bootstrap('frontController');
        $auth = Zend_Auth::getInstance();
        $acl = new Plugin_Auth_Acl();
        $this->getResource('frontController')->registerPlugin(new Plugin_Auth_AccessControl($auth, $acl))->setParam('auth', $auth);
    }

   /*   protected function _initFirebug() {
      $writer = new Zend_Log_Writer_Firebug();
      $logger = new Zend_Log($writer);

      Zend_Registry::set('firebug', $logger);

      $profiler = new Zend_Db_Profiler_Firebug('All DB Queries');
      $profiler->setEnabled(true);

      $resource = $this->getPluginResource('db');
      $db = $resource->getDbAdapter();
      $db->setProfiler($profiler);
      //get all data as object
      //$db->setFetchMode(Zend_Db::FETCH_OBJ);


      //$logger->log($this, Zend_Log::INFO);
      }
    */
}

