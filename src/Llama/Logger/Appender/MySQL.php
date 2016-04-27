<?php
namespace Llama\Logger\Appender;

use Llama\Logger\AppenderInterface;
use Llama\Logger\EventInterface;

/**
 *
 *
 * @category   Llama
 * @package    Logger
 * @subpackage Appender
 * @author     Brendan Smith <brendan.s@crazydomains.com>
 * @version    1.0
 *
 * @uses       \Llama\Logger\AppenderInterface
 * @uses       \Llama\Logger\EventInterface
 */
class MySQL implements AppenderInterface
{

    /**
     * Constructor
     *
     * Configures the appender.
     *
     * @param array $config
     *
     * @access public
     */
    public function __construct(array $config)
    {
        //
    }

    /**
     *
     *
     * @param array $config
     *
     * @access public
     */
    public function append(EventInterface $event)
    {
        //
    }

    /**
     *
     *
     * @param array $config
     *
     * @access public
     */
    public function log(EventInterface $event)
    {
        //
    }
}

