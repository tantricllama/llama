<?php
namespace Llama\Logger;

/**
 * Event Interface class for use in Llama\Logger.
 *
 * @category   Llama
 * @package    Logger
 * @subpackage Event
 * @author     Brendan Smith <brendan.s@crazydomains.com>
 * @version    1.0
 */
interface EventInterface
{

    /**
     * Constructor
     *
     * Sets up the Event object.
     *
     * @param int           $level   The event level.
     * @param string        $message The event message.
     * @param int[optional] $code    The optional event code.
     *
     * @access public
     */
    public function __construct($level, $message, $code = null);

    /**
     * Return the event's level.
     *
     * @access public
     * @return string
     */
    public function getLevel();

    /**
     * Return the event's message.
     *
     * @access public
     * @return string
     */
    public function getMessage();

    /**
     * Return the event's code.
     *
     * @access public
     * @return string
     */
    public function getCode();

    /**
     * Return the file the event occurred in.
     *
     * @access public
     * @return string
     */
    public function getFile();

    /**
     * Return the line the event occurred on.
     *
     * @access public
     * @return string
     */
    public function getLine();

    /**
     * Return time at which the event occurred.
     *
     * @access public
     * @return float
     */
    public function getTimestamp();
}

