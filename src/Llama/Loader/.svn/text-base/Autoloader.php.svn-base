<?php
namespace Llama\Loader;

/**
 * SplClassLoader implementation that implements the technical interoperability
 * standards for PHP 5.3 namespaces and class names. Example usage:
 *
 *   $autoloader = new Autoloader();
 *   $autoloader->addNamespace('Llama\Controller', '/path/to/llama');
 *   $autoloader->register();
 *
 * @category Llama
 * @package  Loader
 * @author   Brendan Smith <brendan.s@crazydomains.com>
 * @version  1.0
 */
class Autoloader
{

    /**
     * A key=>value array for mapping namespaces to their include path.
     *
     * @access private
     * @var    array
     */
    private $namespaces;

    /**
     * Tells the object if it has been added to the SPL autolod stack.
     *
     * @access private
     * @var    bool
     */
    private $registered;

    /**
     * The instance of the autoloader.
     *
     * @access    private
     * @staticvar \Llama\Loader\Autoloader
     */
    static private $instance;

    /**
     * Constructor
     *
     * Set up the Autoloader object.
     *
     * @access private
     */
    private function __construct()
    {
        $this->namespaces = array();
        $this->registered = false;
    }

    /**
     * Add a namespace to the autoload stack.
     *
     * @param string           $namespace   The namespace to add to the autoloader
     *                                      stack.
     * @param string[optional] $includePath The optional include path. If not
     *                                      specified, the default include path
     *                                      will be used.
     *
     * @access public
     * @return string
     */
    public function addNamespace($namespace, $includePath = null)
    {
        $this->namespaces[$namespace] = $includePath;

        return $this;
    }

    /**
     * Install this class loader on the SPL autoload stack.
     *
     * @access public
     * @return void
     */
    public function register()
    {
        if (!$this->registered) {
            spl_autoload_register(array($this, 'loadClass'));

            $this->registered = true;
        }
    }

    /**
     * Uninstall this class loader from the SPL autoloader stack.
     *
     * @access public
     * @return void
     */
    public function unregister()
    {
        spl_autoload_unregister(array($this, 'loadClass'));
    }

    /**
     * Load the given class or interface.
     *
     * @param string $className The name of the class to load.
     *
     * @access public
     * @return void
     */
    public function loadClass($className)
    {
        foreach ($this->namespaces as $namespace => $includePath) {
            if (null === $namespace || $namespace . '\\' === substr($className, 0, strlen($namespace . '\\'))) {
                $fileName = '';
                $namespace = '';

                if (false !== ($lastNsPos = strripos($className, '\\'))) {
                    $namespace = substr($className, 0, $lastNsPos);
                    $className = substr($className, $lastNsPos + 1);
                    $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
                }

                $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

                require ($includePath !== null ? $includePath . DIRECTORY_SEPARATOR : '') . $fileName;
                return;
            }
        }
    }

    /**
     * Instantiate, if necessary, and return the autoloader.
     *
     * @access public
     * @return \Llama\Loader\Autoloader
     * @static
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}

