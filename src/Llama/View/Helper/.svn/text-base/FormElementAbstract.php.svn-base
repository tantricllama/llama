<?php
namespace Llama\View\Helper;

use Llama\View\Helper\HelperInterface;

/**
 * Abstract Form Element class for use in Llama\View\Helper
 *
 * @category   Llama
 * @package    View
 * @subpackage Helper
 * @author     Brendan Smith <brendan.s@crazydomains.com>
 * @version    1.0
 * @abstract
 *
 * @uses \Llama\View\Helper\HelperInterface
 */
abstract class FormElementAbstract implements HelperInterface
{

    /**
     * Returns a string of HTML Tag attributes.
     *
     * @param array $attributes A array of name/value pair HTML Tag attributes.
     *
     * @access protected
     * @return string
     */
    protected function attributes(array $attributes)
    {
        $return = '';

        foreach ($attributes as $name => $value) {
            $return .= " {$name}=\"{$value}\"";
        }

        return $return;
    }
}

