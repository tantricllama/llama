<?php
namespace Llama;

use Llama\Configuration\Reader\INI;
use Llama\Controller\Router;
use Llama\Locale;

/**
 * Application class for use in Llama.
 *
 * @category Llama
 * @package  Application
 * @author   Brendan Smith <brendan.s@crazydomains.com>
 * @version  1.0
 *
 * @uses \Llama\Configuration\Reader\INI
 * @uses \Llama\Controller\Router
 * @uses \Llama\Locale
 */
class Application
{

    /**
     * The application's current working environment (e.g., development, testing, production).
     *
     * @access private
     * @var    string
     */
    private $environment;

    /**
     * The application's configuration data.
     *
     * @access private
     * @var    \Llama\Configuration
     */
    private $configuration;

    /**
     * The application's bootstrap object.
     *
     * @access private
     * @var    \Llama\Application\BootstrapAbstract
     */
    private $bootstrap;

    /**
     * The application's HTTP request router.
     *
     * @access private
     * @var    \Llama\Controller\Router
     */
    private $router;

    /**
     * The application's locale object.
     *
     * @access private
     * @var    \Llama\Locale
     */
    private $locale;

    /**
     * Constructor
     *
     * Setup the application.
     *
     * @param string           $environment The application's working environment.
     * @param string           $configFile  The path to the application's
     *                                      configuration file.
     * @param string[optional] $locale      The locale the application is running
     *                                      in.
     *
     * @access public
     */
    public function __construct($environment, $configFile, $locale = null)
    {
        $this->environment = $environment;
        $this->router = new Router();
        $this->locale = new Locale($locale);

        $this->loadConfiguration($configFile);
    }

    /**
     * Return the application's current working environment.
     *
     * @access public
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * Return the application's configuration data.
     *
     * @access public
     * @return \Llama\Configuration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * Return the application's HTTP request router.
     *
     * @access public
     * @return \Llama\Controller\Router
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * Return the application's HTTP request router.
     *
     * @access public
     * @return \Llama\Locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Run the application.
     *
     * @param string $uri The URI of the requested action.
     *
     * @access public
     * @return void
     */
    public function run($uri)
    {
        $this->initPhpSettings();
        $this->initModules();

        if (is_null($this->bootstrap)) {
            throw new Application\Exception('No bootstrap file loaded (' . $_SERVER['REQUEST_URI'] . ')');
        }

        $this->bootstrap->run($uri);
    }

    /**
     * Initialise the PHP Settings specified by the application's configuration data.
     *
     * @access private
     * @return void
     */
    private function initPhpSettings()
    {
        if (isset($this->configuration->phpsettings)) {
            foreach ($this->configuration->phpsettings as $ini_name => $ini_value) {
                switch ($ini_name) {
                    case 'error_reporting':
                        error_reporting($ini_value);
                        break;
                    default:
                        ini_set($ini_name, $ini_value);
                }
            }
        }
    }

    /**
     * Initialise the application's modules.
     *
     * @access private
     * @throws \Llama\Application\Exception
     * @return void
     */
    private function initModules()
    {
        if (!isset($this->configuration->resources->module_path)) {
            throw new Exception('No module path defined');
        }

        if (sizeof($this->configuration->resources->modules) == 0) {
            throw new Exception('No modules found');
        }

        //add the module path to the include path
        set_include_path(get_include_path() . PATH_SEPARATOR . realpath($this->configuration->resources->module_path));

        foreach ($this->configuration->resources->modules as $module) {
            require_once(realpath($this->configuration->resources->module_path . '/' . $module) . '/Bootstrap.php');

            $className = '\\' . $this->formatModuleName($module) . '\\Bootstrap';
            $this->bootstrap = new $className($this);

            break;
        }
    }

    /**
     * Load the applications configuration file.
     *
     * @param string $configFile The path to the configuration file.
     *
     * @access public
     * @throws \Llama\Application\Exception
     * @return void
     */
    private function loadConfiguration($configFile)
    {
        switch (pathinfo($configFile, PATHINFO_EXTENSION)) {
            case 'ini':
                $this->configuration = new INI($configFile, $this->environment);
                return;
        }

        throw new Exception('Unable to load configuration file');
    }

    /**
     * Convert a module name to a camel-cased string.
     *
     * @param string $name The module name separated by underscores.
     *
     * @access public
     * @return string
     */
    private function formatModuleName($name)
    {
        return str_replace(' ', '_', ucwords(str_replace('_', ' ', $name)));
    }
}

