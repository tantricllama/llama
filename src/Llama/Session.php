<?php
namespace Llama;

use Llama\Session\SessionInterface;

/**
 * Session class for use in Llama.
 *
 * @category Llama
 * @package  Session
 * @author   Brendan Smith <brendan.s@crazydomains.com>
 * @version  1.0
 *
 * @uses \Llama\Session\SessionInterface
 */
class Session implements SessionInterface
{

    /**
     * Used as a reference to the $_SESSION superglobal.
     *
     * @access protected
     * @var    array
     */
    protected $data;

    /**
     * Construct the session object and start the session.
     *
     * @param string           $name The name to be given to the session cookie.
     * @param string[optional] $id   A custom id to set as the value of the
     *                               session cookie.
     *
     * @access public
     */
    public function __construct($name, $id = null)
    {
        session_name($name);

        if (!is_null($id)) {
            session_id($id);
        }

        session_start();

        $this->data = &$_SESSION;
    }

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
    public function set($name, $value)
    {
        $this->data[$name] = $value;
    }

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
    public function get($name, $default = null)
    {
        if (!array_key_exists($name, $this->data)) {
            return $default;
        }

        return $this->data[$name];
    }

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
    public function getOnce($name, $default = null)
    {
        $value = $this->get($name, $default);

        unset($this->data[$name]);

        return $value;
    }

    /**
     * Empties the session array and ends the session.
     *
     * @access public
     * @return void
     */
    public function destroy()
    {
        $this->data = array();

        session_destroy();
    }
}

