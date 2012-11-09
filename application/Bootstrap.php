<?php
/**
 * 
 * @author Andrey Solonovich
 *
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected $_config;
    
    /**
     * Config setup
     *
     * @return Zend_Registry
     */
    public function _initConfig ()
    {
        $config = new Zend_Config($this->getOptions());
        $this->_config = $config;
    
        Zend_Registry::set('config', $config);
        return $config;
    }
    public function _initLogErrorsHandler ()
    {
        if(isset($this->_config->errors->phpErrorHandler) && !empty($this->_config->errors->phpErrorHandler)){
            $this->bootstrap('log');
            $logger = $this->getResource('log');
            $logger->registerErrorHandler();
        }
    }
    public function _initCache()
    {
        $cache = $this->getPluginResource('cachemanager')
        ->getCacheManager()->getCache('default');
        Zend_Registry::set('cache', $cache);
        return $cache;
    }
    public function _initDbProfiler ()
    {
        if (APPLICATION_ENV == 'development' ){
            $profiler = new Zend_Db_Profiler_Firebug('All DB Queries');
            $profiler->setEnabled(true);
            $this->bootstrap('db');
            $db = $this->getResource('db');
            $db->setProfiler($profiler);
        }
    }
    /**
     * Bootstrap view
     *
     * @return Zend_View
     */
    public function _initView()
    {
        $layout = $this->getPluginResource('layout')->getLayout();
        $view = $this->getPluginResource('view')->getView();
        $layout->setView($view);
    
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);
    
        return $view;
    }
}