<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	/**
     * Autoload stuff from the default module (which is not in a `modules` subfolder in this project)
     * (Api_, Form_, Model_, Model_DbTable, Plugin_)
     * */
    protected function _initAutoload()
    {
        $moduleLoader = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath'  => APPLICATION_PATH));

        return $moduleLoader;
    }

    public function _initDoctrine()
    {
        $doctrineConfig = $this->getOption('doctrine');

        $manager = Doctrine_Manager::getInstance();
        
        // Creating 2 named connections, to test ZFDebug doctrine plugin
        $manager->openConnection($doctrineConfig['connection_string'], 'one');
        $manager->openConnection($doctrineConfig['connection_string'], 'two');
                
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

		// not in the .ini because we don't always need it
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('ZFDebug_');

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

