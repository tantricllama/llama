<?php
namespace Llama\Logger;

use Llama\Logger\EventInterface;

/**
 * Log Event class for use in Llama\Logger.
 *
 * @category   Llama
 * @package    Logger
 * @subpackage Event
 * @author     Brendan Smith <brendan.s@crazydomains.com>
 * @version    1.0
 *
 * @uses       \Llama\Logger\EventInterface
 */
class Event implements EventInterface
{

    /**
     * Trace level identifier.
     *
     * @var string
     */
    const TRACE = 'Trace';

    /**
     * Debug level identifier.
     *
     * @var string
     */
    const DEBUG = 'Debug';

    /**
     * Info level identifier.
     *
     * @var string
     */
    const INFO = 'Info';

    /**
     * Warning level identifier.
     *
     * @var string
     */
    const WARNING = 'Warning';

    /**
     * Error level identifier.
     *
     * @var string
     */
    const ERROR = 'Error';

    /**
     * Fatal level identifier.
     *
     * @var string
     */
    const FATAL = 'Fatal';

    /**
     * The event's level. This corresponds to the Event objects level constants.
     *
     * @access private
     * @var    string
     */
    private $level;

    /**
     * The event's message.
     *
     * @access private
     * @var    string
     */
    private $message;

    /**
     * The event's code.
     *
     * @access private
     * @var    string
     */
    private $code;

    /**
     * The file the event occurred in.
     *
     * @access private
     * @var    string
     */
    private $file;

    /**
     * The line the even occurred on.
     *
     * @access private
     * @var    string
     */
    private $line;

    /**
     * The time at which the event occurred.
     *
     * @access private
     * @var    string
     */
    private $timestamp;

    /**
     * Constructor
     *
     * Setup the event.
     *
     * @param int           $level   The event level.
     * @param string        $message The event message.
     * @param int[optional] $code    The optional event code.
     */
    public function __construct($level, $message, $code = null)
    {
        $this->level = $level;
        $this->message = $message;
        $this->code = $code;

        if (strnatcmp(phpversion(), '5.3.6') >= 0) {
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, DEBUG_BACKTRACE_IGNORE_ARGS);
        } else {
            $backtrace = debug_backtrace();
        }

        //0 - Logger\Event
        //1 - Logger
        $this->file = @$backtrace[2]['file'];
        $this->line = @$backtrace[2]['line'];
        $this->timestamp = time();
    }

    /**
     * Return the event's level.
     *
     * @see \Llama\Logger\EventInterface::getLevel()
     *
     * @access public
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Return the event's level.
     *
     * @see \Llama\Logger\EventInterface::getLevel()
     *
     * @access public
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Return the event's level.
     *
     * @see \Llama\Logger\EventInterface::getLevel()
     *
     * @access public
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Return the event's level.
     *
     * @see \Llama\Logger\EventInterface::getLevel()
     *
     * @access public
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Return the event's level.
     *
     * @see \Llama\Logger\EventInterface::getLevel()
     *
     * @access public
     * @return string
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * Return the event's level.
     *
     * @see \Llama\Logger\EventInterface::getLevel()
     *
     * @access public
     * @return string
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
}

