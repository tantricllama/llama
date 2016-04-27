<?php
namespace Llama\Application;

use Llama\Application;

/**
 * Abstract Bootstrap class for use in Llama\Application.
 *
 * @category Llama
 * @package  Application
 * @author   Brendan Smith <brendan.s@crazydomains.com>
 * @version  1.0
 * @abstract
 *
 * @uses \Llama\Application
 */
abstract class BootstrapAbstract
{

    /**
     * The application object.
     *
     * @access protected
     * @var    \Llama\Application
     */
    protected $application;

    /**
     * The controller object.
     *
     * @access protected
     * @var    \Llama\Controller\ControllerAbstract
     */
    protected $controller;

    /**
     * Constructor
     *
     * Setup the bootstrap object.
     *
     * @param \Llama\Application $application The application object.
     *
     * @access public
     * @return void
     */
    public function __construct(\Llama\Application $application)
    {
        $this->application = $application;
    }

    /**
     * Return the application object.
     *
     * @access public
     * @return \Llama\Application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * Return the application controller object.
     *
     * @access public
     * @return \Llama\Controller\ControllerAbstract
     */
    public function getController()
    {
        if (is_null($this->controller)) {
            $controllerName = $this->getRouter()->controller;
            $controllerName = $this->controllerNamespace . '\\' . $controllerName . 'Controller';

            $this->controller = new $controllerName($this);
        }

        return $this->controller;
    }

    /**
     * Return the application's router object.
     *
     * @access public
     * @return \Llama\Controller\Router
     */
    public function getRouter()
    {
        return $this->getApplication()->getRouter();
    }

    /**
     * Return the application's locale object.
     *
     * @access public
     * @return \Llama\Locale
     */
    public function getLocale()
    {
        return $this->getApplication()->getLocale();
    }

    /**
     * Return the bootstrap namespace.
     *
     * @access public
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Run the requested action.
     *
     * @param string[optional] $action The name of the action to run.
     *
     * @access public
     * @return void
     */
    public function runAction($action = null)
    {
        if (is_null($action)) {
            $action = $this->getRouter()->action;
        }

        $action .= 'Action';

        $this->controller->runBeforeFilter($action);
        $this->controller->$action();
        $this->controller->runAfterFilter($action);
    }
}

