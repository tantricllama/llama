<?php
namespace Llama\Logger;

use Llama\Logger\EventInterface;

/**
 * Appender Interface class for use in Llama\Logger.
 *
 * @category   Llama
 * @package    Logger
 * @subpackage Appender
 * @author     Brendan Smith <brendan.s@crazydomains.com>
 * @version    1.0
 */
interface AppenderInterface
{

    /**
     * Append a log event to the stack.
     *
     * @param EventInterface $event The log event.
     *
     * @access public
     * @return void
     */
    public function append(EventInterface $event);

    /**
     * Record the log event stack.
     *
     * @access public
     * @return void
     */
    public function log();
}

