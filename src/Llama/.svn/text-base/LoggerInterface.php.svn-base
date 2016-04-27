<?php
namespace Llama;

/**
 * Logger Interface class for use in Llama.
 *
 * @category Llama
 * @package  Logger
 * @author   Brendan Smith <brendan.s@crazydomains.com>
 * @version  1.0
 */
interface LoggerInterface
{

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
    public function trace($message, $code = null);

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
    public function debug($message, $code = null);

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
    public function info($message, $code = null);

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
    public function warning($message, $code = null);

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
    public function error($message, $code = null);

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
    public function fatal($message, $code = null);

    /**
     * Returns a configured logger by name.
     *
     * @param string $name The name of the logger as defined in the configuration.
     *
     * @static
     * @access public
     * @throws \InvalidArgumentException If no logger with the name exists.
     * @return \Llama\Logger\LoggerInterface
     */
    public static function getLogger($name);

    /**
     * Configures a logger using the given configuration.
     *
     * @param mixed $config The configuration data for the logger. This can be
     *                      given in one of two way; As an object, or as a path
     *                      to a configuration file.
     *
     * @example <i>Object</i> example:
     * <pre>
     *   $config = new stdClass();
     *   $config->method->email->name = 'ExampleLogger';
     *   $config->method->email->from = 'Example Sender <logger@example.com>';
     *   $config->method->email->to = 'Example Recipient <mail@example.com>';
     *   $config->method->email->subject = 'Example Subject';
     *
     *   Logger::configure($config);
     * </pre>
     *
     * @example <i>Configuration File</i> example:
     * <pre>
     *   Logger::configure('example_config.ini');
     * </pre>
     *
     * @example <i>example_config.ini</i> contents:
     * <pre>
     *   logger.method.email.name = ExampleLogger
     *   logger.method.email.from = Example Sender <logger@example.com>
     *   logger.method.email.to = Example Recipient <mail@example.com>
     *   logger.method.email.subject = Example Subject
     * </pre>
     *
     * @static
     * @access public
     * @throws \InvalidArgumentException If no valid configuration is found.
     * @return \Llama\Logger\LoggerInterface
     */
    public static function configure($config);
}

