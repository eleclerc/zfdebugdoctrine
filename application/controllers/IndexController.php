<?php
//require_once 'BaseMessage.php';
//require_once 'Message.php';

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // Using 2 different connection to test ZFDebug Doctrine plugin
        $conn1 = Doctrine_Manager::getInstance()->getConnection('one');
        $posts = Doctrine_Query::create($conn1)
                     ->from('Model_Post p')
                     ->orderBy('p.created_at DESC')
                     ->execute();
                     
        $conn2 = Doctrine_Manager::getInstance()->getConnection('two');
        $dummy = Doctrine_Query::create($conn2)
                    ->from('Model_Post p')
                    ->select('p.content')
                    ->where('p.author = ?', 'danceric')
                    ->execute();
                
        $this->view->posts = $posts;
    }
}



