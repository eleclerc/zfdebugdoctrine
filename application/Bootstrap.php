<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function _initDoctrine()
    {
        $doctrineConfig = $this->getOption('doctrine');
            
        $loader = Zend_Loader_Autoloader::getInstance();
        
        require_once 'Doctrine.php';
        $loader->pushAutoloader(array('Doctrine', 'autoload'));

        $manager = Doctrine_Manager::getInstance();
        $manager->setAttribute(Doctrine::ATTR_MODEL_LOADING, Doctrine::MODEL_LOADING_CONSERVATIVE);
        
        // Creating 2 named connections, to test ZFDebug doctrine plugin
        $manager->openConnection($doctrineConfig['connection_string'], 'one');
        $manager->openConnection($doctrineConfig['connection_string'], 'two');
                
        // Add model and generated base class to doctrine autoloader
        Doctrine::loadModels($doctrineConfig['models_path']);
        
        return $manager;
    }
    
    /**
     * Initialize the ZFDebug Bar
     */
    protected function _initZFDebug()
    {
        $zfdebugConfig = $this->getOption('zfdebug');

        if ($zfdebugConfig['enabled'] != 1) {
            return;
        }

        // Ensure Doctrine connection instance is present, and fetch it
        $this->bootstrap('Doctrine');
        $doctrine = $this->getResource('Doctrine');

        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('ZFDebug');

        $options = array(
            'plugins' => array('Variables',
                               'Danceric_Controller_Plugin_Debug_Plugin_Doctrine',
                               'File',
                               'Memory',
                               'Time',
                               'Exception'),
            //'jquery_path' => '/js/jquery-1.3.2.min.js'
            );
        $debug = new ZFDebug_Controller_Plugin_Debug($options);

        $this->bootstrap('frontController');
        $frontController = $this->getResource('frontController');
        $frontController->registerPlugin($debug);
    }
}

