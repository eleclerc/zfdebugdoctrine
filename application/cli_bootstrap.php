<?php
/**
 * Common stuff used by Command Line Interface applications.
 *
 * The CLI app still need to call the bootstrap with the resource(s) to load as argument (string|array)
 *      $application->bootstrap('db');
 * Resource can be accessed like this
 *      $db = $application->getBootstrap()->getResource('db');
 */

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', dirname(__FILE__));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);