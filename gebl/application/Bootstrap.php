<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function _initCache (){
    $frontendOptions = array('automatic_serialization' => true);
    $backendOptions = array('cache_dir'=>'../cache/');
    $dbCache = Zend_Cache::factory('Core','File',$frontendOptions,$backendOptions);
    Zend_Db_Table_Abstract::setDefaultMetadataCache($dbCache);
    }

 protected function _initViewHelpers()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->headMeta()->appendHttpEquiv('Content-Type','text/html:charset=utf-8');
        $view->headLink()->appendStylesheet($view->BaseUrl('/css/screen.css'));
        $view->doctype('XHTML1_STRICT');
        $view->headTitle()->setSeparator(' - ');
        $view->headTitle('GEBL-Karte');
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

    /*protected function _initDBSettings() {
        //SET NLS_NUMERIC_CHARACTERS to "." for Database
        $resource = $bootstrap->getPluginResource('db');
        $db = $resource->getDbAdapter();
        $db->query("alter session set NLS_NUMERIC_CHARACTERS = '. '");
}
*/
}

