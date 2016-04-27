<?php
namespace Llama\Controller;

use Llama\Controller\Exception;

/**
 * Router class for use in Llama\Controller.
 *
 * @category   Llama
 * @package    Controller
 * @subpackage Router
 * @author     Brendan Smith <brendan.s@crazydomains.com>
 * @version    1.0
 *
 * @uses \Llama\Controller\Exception
 */
class Router
{

    /**
     * Contains an array of Route objects.
     *
     * @var mixed
     */
    private $routes;

    /**
     * The URI to match against.
     *
     * @var string
     */
    private $uri;

    /**
     * A boolean that tells the object a match was found.
     *
     * @var bool
     */
    private $matched;

    /**
     * The determined controller.
     *
     * @var string
     */
    public $controller;

    /**
     * The determined action.
     *
     * @var string
     */
    public $action;

    /**
     * Parameters extracted from the URI.
     *
     * @var mixed
     */
    public $params;

    /**
     * Constructor
     *
     * Sets up the Router object.
     *
     * @param string[optional] $uri The URI string.
     *
     * @access public
     */
    public function __construct($uri = '')
    {
        if ($uri == '') {
            if (array_key_exists('REQUEST_URI', $_SERVER)) {
                $uri = $_SERVER['REQUEST_URI'];
            }
        }

        $this->setUri($uri);

        $this->routes = array();
        $this->matched = false;
    }

    /**
     * Set the URI for the routes to match.
     *
     * @param string[optional] $uri The URI string.
     *
     * @access public
     * @return void
     */
    public function setUri($uri = '')
    {
        if ($uri != '') {
            $this->uri = $uri;
        }

        return $this;
    }

    /**
     * Add a route to the routes property. If a route has a rule that has already
     * been added, an exception is raised.
     *
     * @param Route $route The route object.
     *
     * @access public
     * @throws \Llama\Controller\Exception
     * @return void
     */
    public function addRoute(Route $route)
    {
        if (array_key_exists($route->rule, $this->routes)) {
            throw new Exception('Duplicate route detected');
        }

        $this->routes[$route->rule] = $route;
    }

    /**
     * Extracts data from a specified Route object.
     *
     * @param Route $route The matched route object.
     *
     * @access public
     * @return void
     */
    public function setRoute(Route $route)
    {
        $this->controller = $route->controller;
        $this->action = $route->action;
        $this->params = $route->params;

        $this->matched = true;
    }

    /**
     * Loop through the routes property and attempt to match the specified
     * URI. If the routes property is empty, an exception is raised.
     *
     * @access public
     * @throws \Llama\Controller\Exception
     * @return void
     */
    public function initialise()
    {
        if ($this->uri == '') {
            throw new Exception('No URI has been set');
        }

        if ($this->routes == array()) {
            throw new Exception('No routes added');
        }

        foreach ($this->routes as $route) {
            if ($route->match($this->uri)) {
                $this->setRoute($route);

                break;
            }
        }

        //no need to keep the routes, so lets free up some memory
        $this->routes = array();
    }

    /**
     * Return a parameter if it exists, otherwise return the supplied default
     *
     * @param string          $name    The name of the parameter.
     * @param mixed[optional] $default The value to return if the parameter does
     *                                 not exist.
     *
     * @access public
     * @return mixed
     */
    public function getParam($name, $default = null)
    {
        if (array_key_exists($name, $this->params)) {
            return $this->params[$name];
        }

        return $default;
    }

    /**
     * Return the result of the route matches.
     *
     * @access public
     * @return bool
     */
    public function isMatched()
    {
        return $this->matched;
    }
}

