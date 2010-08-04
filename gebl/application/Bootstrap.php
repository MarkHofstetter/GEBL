<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
 protected function _initViewHelpers()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->headMeta()->appendHttpEquiv('Content-Type','text/html:charset=utf-8');
        $view->headLink()->appendStylesheet($view->baseURL('/css/screen.css'));

        $view->doctype('XHTML1_STRICT');
        $view->headTitle()->setSeparator(' - ');
        $view->headTitle('GEBL-Karte');
    }

    protected function _initLanguage() {
        $locale = new Zend_locale('de_AT');
        $translator = new Zend_Translate(
                'array',
                APPLICATION_PATH . '/../resources/languages',
                'de',
                array('scan' => Zend_Translate::LOCALE_DIRECTORY)
                );
        Zend_Validate_Abstract::setDefaultTranslator($translator);
        Zend_Locale::setDefault($locale);

    }

}

