<?php
/**
 * My Zend Framework Project
 * 
 * @author  Andrey Solonovich // andrey@solonovich.name
 * @link www.solonovich.name
 * @version unknown
 */

define('APPLICATION_ENV', 'development');

define('DS', DIRECTORY_SEPARATOR);
date_default_timezone_set("Asia/Nicosia");

define('ROOT_PATH', realpath(dirname(__FILE__) . DS . '..'));
define('WEB_PATH', realpath(dirname(__FILE__)));
define('APPLICATION_PATH', realpath(ROOT_PATH . DS . 'application'));

set_include_path(implode(PATH_SEPARATOR, array(
realpath(ROOT_PATH . DS . 'library'),
get_include_path(),
)));

require_once 'Zend/Application.php';

$application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH  . DS .  'configs' . DS . 'Application.ini');
$application->bootstrap()->run();