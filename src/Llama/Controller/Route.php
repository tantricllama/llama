<?php
namespace Llama\Controller;

use Llama\Controller\Exception;

/**
 * Route class for use in Llama\Controller.
 *
 * @category   Llama
 * @package    Controller
 * @subpackage Router
 * @author     Brendan Smith <brendan.s@crazydomains.com>
 * @version    1.0
 *
 * @uses \Llama\Controller\Exception
 */
class Route
{

    /**
     * Default matching regex for URI parts.
     */
    const DEFAULT_CONSTRAINT_REGEX = '([a-zA-Z0-9_\+\-%]+)';

    /**
     * Any constraints that URI parts are to adhere to.
     *
     * @access private
     * @var    mixed
     */
    private $constraints;

    /**
     * Rule the URI must match.
     *
     * @access public
     * @var    string
     */
    public $rule;

    /**
     * The determined controller.
     *
     * @access public
     * @var    string
     */
    public $controller;

    /**
     * The determined action.
     *
     * @access public
     * @var    string
     */
    public $action;

    /**
     * Parameters extracted from the URI.
     *
     * @access public
     * @var    array
     */
    public $params;

    /**
     * Constructor
     *
     * Set up the Route object.
     *
     * If specified, a constraint key must have a matching key in the rule. For example:
     *
     * Rule:
     *  - /user/view/:id/
     *
     * Contstraint:
     *  - array(
     *      'id' => '[\d]+'
     *    )
     *
     * @param string           $rule        The rule to match the URI against.
     * @param array[ooptional] $target      An array containing the target
     *                                      controller and action.
     * @param array[ooptional] $constraints An array of constraints for each
     *                                      key in the rule.
     *
     * @access public
     * @throws \Llama\Controller\Exception
     */
    public function __construct($rule = '', $target = array(), $constraints = array())
    {
        if (empty($rule)) {
            throw new Exception('Rule is empty');
        }

        $this->rule = $rule;
        $this->constraints = $constraints;

        if (array_key_exists('controller', $target) && !empty($target['controller'])) {
            $this->controller = $target['controller'];
        }

        if (array_key_exists('action', $target) && !empty($target['action'])) {
            $this->action = $target['action'];
        }

        $this->params = array_key_exists('params', $target) ? $target['params'] : array();
    }

    /**
     * Determine if a given URI matches the rule.
     *
     * @param string $uri The URI to match against the rule.
     *
     * @access public
     * @return bool
     */
    public function match($uri)
    {
        preg_match_all('@:([\w]+)@', $this->rule, $paramNames, PREG_PATTERN_ORDER);

        $paramNames = $paramNames[0];
        $regex = preg_replace_callback('@:[\w]+@', array($this, 'getConstraint'), $this->rule);

        if (preg_match('@^' . $regex . '/?$@', $uri, $paramValues)) {
            array_shift($paramValues);

            foreach ($paramNames as $index => $value) {
                if ($value == ':controller') {
                    $this->controller = urldecode($paramValues[$index]);
                } elseif ($value == ':action') {
                    $this->action = urldecode($paramValues[$index]);
                } else {
                    $this->params[substr($value, 1)] = urldecode($paramValues[$index]);
                }
            }

            return true;
        }

        return false;
    }

    /**
     * Retrieve the given constraint for a key. If one does not exist, return the
     * default constraint regex.
     *
     * @param mixed $key The key the restraint is used for.
     *
     * @access public
     * @return string
     */
    public function getConstraint($key)
    {
        $key = substr($key[0], 1);

        if (array_key_exists($key, $this->constraints)) {
            return '(' . $this->constraints[$key] . ')';
        }

        return self::DEFAULT_CONSTRAINT_REGEX;
    }
}

