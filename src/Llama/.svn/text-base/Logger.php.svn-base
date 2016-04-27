<?php
namespace Llama;

use InvalidArgumentException;
use Llama\Logger\AppenderInterface;
use Llama\LoggerInterface;
use Llama\Logger\Event;
use Llama\Logger\EventInterface;
use RuntimeException;

/**
 * Logger class for use in Llama Applications.
 *
 * @category Llama
 * @package  Logger
 * @author   Brendan Smith <brendan.s@crazydomains.com>
 * @version  1.0
 *
 * @uses     \InvalidArgumentException
 * @uses     \Llama\Logger\AppenderInterface
 * @uses     \Llama\Logger\LoggerInterface
 * @uses     \Llama\Logger\EventInterface
 * @uses     \RuntimeException
 *
 * @example
 * $logger = Logger::configure('path/to/config.ini');
 * $logger->info('Hello world!');
 * $logger->fatal('Goodbye cruel world!');
 */
class Logger implements LoggerInterface
{

    /**
     * Stores the name of the logger.
     *
     * @access private
     * @var    string
     */
    private $name;

    /**
     * Stores the configured appender for the logger.
     *
     * @access private
     * @var    \Llama\Logger\AppenderInterface
     */
    private $appender;

    /**
     * Stores configured loggers using logger names as keys.
     *
     * @access private
     * @var    array
     */
    static private $loggers;

    /**
     * Stores all acceptable logging appenders. Any new methods must be added to
     * this array.
     *
     * @see \Llama\Logger::configure()
     *
     * @access private
     * @var    array
     */
    static private $loggingAppenders = array(
        'email' => 'Llama\\Logger\\Appender\\Email',
        'mysql' => 'Llama\\Logger\\Appender\\MySQL'
    );

    /**
     * Constructor
     *
     * Adds the appender to the internal array.
     *
     * @param string            $name     The message to be logged.
     * @param AppenderInterface $appender An optional code for tracking event
     *                                    types based on an external list.
     *
     * @access public
     */
    public function __construct($name, AppenderInterface $appender)
    {
        $this->name = $name;
        $this->appender = $appender;
    }

    /**
     * Triggers a trace level logging event.
     *
     * @param string        $message The message to be logged.
     * @param int[optional] $code    An optional code for tracking event types
     *                               based on an external list.
     *
     * @access public
     * @return void
     */
    public function trace($message, $code = null)
    {
        $this->log(new Event(Event::TRACE, $message, $code));
    }

    /**
     * Triggers a debug level logging event.
     *
     * @param string        $message The message to be logged.
     * @param int[optional] $code    An optional code for tracking event types
     *                               based on an external list.
     *
     * @access public
     * @return void
     */
    public function debug($message, $code = null)
    {
        $this->log(new Event(Event::DEBUG, $message, $code));
    }

    /**
     * Triggers an info level logging event.
     *
     * @param string        $message The message to be logged.
     * @param int[optional] $code    An optional code for tracking event types
     *                               based on an external list.
     *
     * @access public
     * @return void
     */
    public function info($message, $code = null)
    {
        $this->log(new Event(Event::INFO, $message, $code));
    }

    /**
     * Triggers a warning level logging event.
     *
     * @param string        $message The message to be logged.
     * @param int[optional] $code    An optional code for tracking event types
     *                               based on an external list.
     *
     * @access public
     * @return void
     */
    public function warning($message, $code = null)
    {
        $this->log(new Event(Event::WARNING, $message, $code));
    }

    /**
     * Triggers an error level logging event.
     *
     * @param string        $message The message to be logged.
     * @param int[optional] $code    An optional code for tracking event types
     *                               based on an external list.
     *
     * @access public
     * @return void
     */
    public function error($message, $code = null)
    {
        $this->log(new Event(Event::ERROR, $message, $code));
    }

    /**
     * Triggers a fatal level logging event.
     *
     * @param string        $message The message to be logged.
     * @param int[optional] $code    An optional code for tracking event types
     *                               based on an external list.
     *
     * @access public
     * @return void
     */
    public function fatal($message, $code = null)
    {
        $this->log(new Event(Event::FATAL, $message, $code));
    }

    /**
     * Desctructor
     *
     * Log the event stack.
     *
     * @access public
     * @return void
     */
    public function __destruct()
    {
        $this->appender->log();
    }

    /**
     * Appends the event to the stack.
     *
     * @param EventInterface $event The message to be logged.
     *
     * @access public
     * @return void
     */
    private function log(EventInterface $event)
    {
        $this->appender->append($event);
    }

    /**
     * Returns a configured logger by name.
     *
     * @param string $name The name of the logger as defined in the configuration.
     *
     * @static
     * @access public
     * @throws \RuntimeException If no logger with the name exists.
     * @return \Llama\Logger\LoggerInterface
     */
    public static function getLogger($name)
    {
        if (!array_key_exists($name, self::$loggers)) {
            throw new \RuntimeException('Logger "' . $name . '" not found');
        }

        return self::$loggers[$name];
    }

    /**
     * Configures a logger using the given configuration.
     *
     * @param string $config The path to a configuration file.
     *
     * @example
     * <pre>
     *   Logger::configure('example_config.ini');
     * </pre>
     *
     * @example <i>example_config.ini</i> contents:
     * <pre>
     *   logger.appender.email.name = ExampleLogger
     *   logger.appender.email.from = Example Sender <logger@example.com>
     *   logger.appender.email.to = Example Recipient <mail@example.com>
     *   logger.appender.email.subject = Example Subject
     * </pre>
     *
     * @static
     * @access public
     * @throws \InvalidArgumentException If no valid configuration is found.
     * @return \Llama\Logger\LoggerInterface
     */
    public static function configure($config)
    {
        if (!is_file($config)) {
            throw new InvalidArgumentException('Configuration file does not exist');
        }

        if (!is_readable($config)) {
            throw new InvalidArgumentException('Configuration file is not readable');
        }

        $baseConfig = self::getConfigFromFile($config);
        $appender = array_intersect_key(self::$loggingAppenders, $baseConfig['logger']['appender']);

        if (empty($appender)) {
            throw new InvalidArgumentException('No valid appender was found');
        }

        $appenderType = key($appender);
        $appenderClass = current($appender);
        $appenderConfig = $baseConfig['logger']['appender'][$appenderType];

        self::$loggers[$appenderConfig['name']] = new self(
            $appenderConfig['name'],
            new $appenderClass($appenderConfig)
        );

        return self::$loggers[$appenderConfig['name']];
    }

    /**
     * Reads a configuration file and returns its contents as an object.
     *
     * @param string $filePath The path to the configuration file.
     *
     * @static
     * @access private
     * @return array
     */
    private static function getConfigFromFile($filePath)
    {
        $loaded = parse_ini_file($filePath);
        $config = array();

        foreach ($loaded as $key => $data) {
            $config = self::processConfigKey($config, $key, $data);
        }

        return $config;
    }

    /**
     * Recursively creates a child array for each period (.) separated section of
     * the key and returns parent array.
     *
     * @param array  $config The parent object.
     * @param string $key    The key to use for the child objects.
     * @param string $data   The data for the respective key.
     *
     * @example
     * <pre>
     *   var_dump(self::processConfigKey(array(), 'test.key', 'value'));
     *
     *   //output
     *   array
     *   &nbsp;&nbsp;'test' =>
     *   &nbsp;&nbsp;&nbsp;&nbsp;array
     *   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'key' => string 'value' (length=5)
     * </pre>
     *
     * @static
     * @access private
     * @return array
     */
    private static function processConfigKey($config, $key, $data)
    {
        if (strpos($key, '.') !== false) {
            $pieces = explode('.', $key, 2);

            if (!array_key_exists($pieces[0], $config)) {
                $config[$pieces[0]] = array();
            }

            $config[$pieces[0]] = self::processConfigKey($config[$pieces[0]], $pieces[1], $data);
        } else {
            $config[$key] = $data;
        }

        return $config;
    }
}

