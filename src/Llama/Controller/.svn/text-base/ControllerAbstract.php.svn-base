<?php
namespace Llama\Controller;

use Llama\Database\PDOAdapter;
use Llama\Session\SessionInterface;

/**
 * Abstract Controller class for use in Llama.
 *
 * @category Llama
 * @package  Controller
 * @author   Brendan Smith <brendan.s@crazydomains.com>
 * @version  1.0
 * @abstract
 *
 * @uses \Llama\Database\PDOAdapter
 * @uses \Llama\Session\SessionInterface
 */
abstract class ControllerAbstract
{

    /**
     * The application bootstrap object.
     *
     * @access protected
     * @var    \Llama\Application\BootstrapAbstract
     */
    protected $bootstrap;

    /**
     * An array with the before filter methods as the keys, and the methods that
     * need to run the filters in a child array.
     *
     * @access protected
     * @var    array
     */
    protected $beforeFilters = array();

    /**
     * An array with the after filter methods as the keys, and the methods that
     * need to run the filters in a child array.
     *
     * @access protected
     * @var    array
     */
    protected $afterFilters = array();

    /**
     * An array of helper objects.
     *
     * @access protected
     * @var    array
     */
    protected $helpers = array();

    /**
     * An array of helper class names.
     *
     * @access protected
     * @var    array
     */
    protected $helperPaths = array();

    /**
     * The data adapter.
     *
     * @access protected
     * @var    \Llama\Database\Adapter\AdapterInterface
     */
    protected $adapter;

    /**
     * The session storage object.
     *
     * @access protected
     * @var    \Llama\Session\SessionInterface
     */
    protected $sessionStorage;

    /**
     * Constructor
     *
     * Setup the controller object.
     *
     * @param \Llama\Application\BootstrapAbstract $bootstrap The application's
     *                                                        bootstrap object.
     *
     * @access public
     */
    public function __construct($bootstrap)
    {
        $this->bootstrap = $bootstrap;
    }

    /**
     * Return the application's bootstrap object.
     *
     * @access public
     * @return \Llama\Application\BootstrapAbstract
     */
    public function getBooststrap()
    {
        return $this->bootstrap;
    }

    /**
     * Return the application object.
     *
     * @access public
     * @return \Llama\Application
     */
    public function getApplication()
    {
        return $this->getBooststrap()->getApplication();
    }

    /**
     * Return the application's configuration object.
     *
     * @access public
     * @return \Llama\Configuration
     */
    public function getConfiguration()
    {
        return $this->getBooststrap()->getApplication()->getConfiguration();
    }

    /**
     * Return the application's HTTP request router.
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
     * @return \Llama\Controller\Router
     */
    public function getLocale()
    {
        return $this->getApplication()->getLocale();
    }

    /**
     * Instantiate, if necessary, and return a view helper object.
     *
     * @param string $name The short name of the helper.
     *
     * @access public
     * @return \Llama\View\Helper
     */
    public function getHelper($name)
    {
        if (!array_key_exists($name, $this->helpers)) {
            $this->helpers[$name] = new $this->helperPaths[$name];
        }

        return $this->helpers[$name];
    }

    /**
     * An a helper classname to the list of available helpers.
     *
     * @param string $name  The short name by which the helper will be called in
     *                      the view.
     * @param string $class The namespace of the class.
     *
     * @access public
     * @return void
     */
    public function addHelperPath($name, $class)
    {
        $this->helperPaths[$name] = $class;
    }

    /**
     * Instantiate, if necessary, and the return data adapter object.
     *
     * @access public
     * @return \Llama\Database\Adapter\AdapterInterface
     */
    public function getAdapter()
    {
        if (is_null($this->adapter)) {
            $this->adapter = new PDOAdapter(
                'mysql:dbname=' . $this->getApplication()->getConfiguration()->resources->db->name,
                $this->getApplication()->getConfiguration()->resources->db->username,
                $this->getApplication()->getConfiguration()->resources->db->password
            );
        }

        return $this->adapter;
    }

    /**
     * Set the session storage object.
     *
     * @param \Llama\Session\SessionInterface $session The session storage object.
     *
     * @access public
     * @return void
     */
    public function setSessionStorage(SessionInterface $session)
    {
        $this->sessionStorage = $session;
    }

    /**
     * Return the session storage object.
     *
     * @access public
     * @return \Llama\Session\SessionInterface
     */
    public function getSessionStorage()
    {
        return $this->sessionStorage;
    }

    /**
     * Run the before filters for the requested action.
     *
     * @param string $action The name of the action.
     *
     * @access public
     * @return void
     */
    public function runBeforeFilter($action)
    {
        foreach ($this->beforeFilters as $filter => $actions) {
            if (in_array($action, $actions)) {
                $this->$filter();
            }
        }
    }

    /**
     * Run the after filters for the requested action.
     *
     * @param string $action The name of the action.
     *
     * @access public
     * @return void
     */
    public function runAfterFilter($action)
    {
        foreach ($this->afterFilters as $filter => $actions) {
            if (in_array($action, $actions)) {
                $this->$filter();
            }
        }
    }

    /**
     * Render the view.
     *
     * @param string           $view   The name of the view to render.
     * @param array            $params The parameters used to render the view.
     * @param string[optional] $layout The layout file to use.
     *
     * @todo Figure out a way to ensure the view file exists.
     *
     * @access public
     * @return void
     */
    public function render($view, array $params = array(), $layout = null)
    {
        $viewFile = $view . '.phtml';

        $this->renderLayout($viewFile, $params, $layout);
    }

    /**
     * Render a view with its layout.
     *
     * @param string $viewFile The filename of the view.
     * @param array  $params   The parameters used to render the view.
     * @param string $layout   The layout file to use.
     *
     * @access public
     * @return void
     */
    public function renderLayout($viewFile, $params, $layout)
    {
        extract($params);

        ob_start();
        require_once($viewFile);

        if (!is_null($layout)) {
            $contents = ob_get_clean();

            $layoutFile = $layout . '.phtml';
            require_once($layoutFile);
        }

        ob_end_flush();
    }

    // -- Magic Methods

    /**
     * Magic method __call used within a view file to call methods of a helper
     * object.
     *
     * @param string $name      The short name of the helper to use.
     * @param array  $arguments The arguments to pass to the helper method.
     *
     * @access public
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $helper = $this->getHelper($name);

        return call_user_func_array(array($helper, $name), $arguments);
    }
}

