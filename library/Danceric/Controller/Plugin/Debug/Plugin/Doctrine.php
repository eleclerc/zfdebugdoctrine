<?php
/**
 * ZFDebug Doctrine ORM plugin
 *
 * @category   Danceric
 * @package    Danceric_Controller
 * @subpackage Plugins
 */

/**
 * @category   Danceric
 * @package    Danceric_Controller
 * @subpackage Plugins
 */
class Danceric_Controller_Plugin_Debug_Plugin_Doctrine extends ZFDebug_Controller_Plugin_Debug_Plugin implements ZFDebug_Controller_Plugin_Debug_Plugin_Interface
{
    /**
     * Contains plugin identifier name
     *
     * @var string
     */
    protected $_identifier = 'doctrine';

    /**
     * @var array Doctrine connection profiler that will listen to events
     */
    protected $_profilers = array();

    /**
     * Create ZFDebug_Controller_Plugin_Debug_Plugin_Variables
     *
     * @param Doctrine_Manager|array $options
     * @return void
     */
    public function __construct(array $options = array())
    {
        if(!isset($options['manager']) || !count($options['manager'])) {
            if (Doctrine_Manager::getInstance()) {
                $options['manager'] = Doctrine_Manager::getInstance();
            }
        }

        foreach ($options['manager']->getIterator() as $connection) {
            $this->_profilers[$connection->getName()] = new Doctrine_Connection_Profiler();
            $connection->setListener($this->_profilers[$connection->getName()]);
        }
    }

    /**
     * Gets identifier for this plugin
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->_identifier;
    }

    /**
     * Gets menu tab for the Debugbar
     *
     * @return string
     */
    public function getTab()
    {
        if (!$this->_profilers)
            return 'No Profiler';

        foreach ($this->_profilers as $profiler) {
            $time = 0;
            foreach ($profiler as $event) {
                $time += $event->getElapsedSecs();
            }
            $profilerInfo[] = $profiler->count() . ' in ' . round($time*1000, 2)  . ' ms';
        }
        $html = implode(' / ', $profilerInfo);

        return $html;
    }

    /**
     * Gets content panel for the Debugbar
     *
     * @return string
     */
    public function getPanel()
    {
        if (!$this->_profilers)
            return '';

        $html = '<h4>Database queries</h4>';
        
        foreach ($this->_profilers as $name => $profiler) {
                $html .= '<h4>Connection '.$name.'</h4><ol>';
                foreach ($profiler as $event) {
                    if ($event->getName() == 'query' || $event->getName() == 'execute') {
                        $query = $event->getQuery();
                    } else {
                        $query = $event->getName();
                    }
                    $html .= '<li><strong>[' . round($event->getElapsedSecs()*1000, 2) . ' ms]</strong> ';
                    $html .= htmlspecialchars($query) . "</li>";
                    $params = $event->getParams();
                    if( ! empty($params)) {
                        $html .= print_r($params, 1);
                    }
                }
                $html .= '</ol>';
        }

        return $html;
    }

}