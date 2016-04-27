<?php
namespace Llama\Session;

/**
 * Session Interface class for use in Llama\Session.
 *
 * @category Llama
 * @package  Session
 * @author   Brendan Smith <brendan.s@crazydomains.com>
 * @version  1.0
 */
interface SessionInterface
{

    /**
     * Construct the session object and start the session.
     *
     * @param string           $name The name to be given to the session cookie.
     * @param string[optional] $id   A custom id to set as the value of the
     *                               session cookie.
     *
     * @access public
     */
    public function __construct($name, $id = null);

    /**
     * Set a name/value pair in the session array.
     *
     * @param string $name  The name in the session array which can be used to
     *                      reference the value.
     * @param mixed  $value A value to store in the session array.
     *
     * @access public
     * @return void
     */
    public function set($name, $value);

    /**
     * Get a value from the session array.
     *
     * @param string          $name    The name of the value to return from the
     *                                 session array.
     * @param mixed[optional] $default An optional value to return if the name
     *                                 is not found.
     *
     * @access public
     * @return mixed
     */
    public function get($name, $default = null);

    /**
     * Get a value from the session array and remove it from the array.
     *
     * @param string          $name    The name of the value to return from the
     *                                 session array.
     * @param mixed[optional] $default An optional value to return if the name is
     *                                 not found.
     *
     * @access public
     * @return mixed
     */
    public function getOnce($name, $default = null);

    /**
     * Empties the session array and ends the session.
     *
     * @access public
     * @return void
     */
    public function destroy();
}

