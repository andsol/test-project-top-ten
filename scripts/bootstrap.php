<?php
    
    // Eviroment settings
    define('APPLICATION_ENV', 'development');
    
    define('DS', DIRECTORY_SEPARATOR);
    
    define('ROOT_PATH', realpath(dirname(__FILE__) . '/..'));
    define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application/'));

    set_include_path(implode(PATH_SEPARATOR, array(
        APPLICATION_PATH,
        realpath(ROOT_PATH . DS . 'library'),
        get_include_path(),
    )));
    
    require_once 'Zend/Loader/Autoloader.php';
    Zend_Loader_Autoloader::getInstance();
    
    // Application
    $application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH  . DS .  'configs' . DS . 'application.ini');
    
    $application
        // Setup database connetion
        ->bootstrap('db')
        // Setup modules autoloading
        ->bootstrap('modules');