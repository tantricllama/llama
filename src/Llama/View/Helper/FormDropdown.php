<?php
namespace Llama\View\Helper;

/**
 * FormDropdown class for use in Llama\View\Helper.
 *
 * @category   Llama
 * @package    View
 * @subpackage Helper
 * @author     Brendan Smith <brendan.s@crazydomains.com>
 * @version    1.0
 *
 * @uses \Llama\View\Helper\FormElementAbstract
 */
class FormDropdown extends FormElementAbstract
{

    /**
     * Generate an HTML Select element.
     *
     * @param mixed[optional]  $options      If an array, the key/value will be
     *                                       used as the option tag's value/label
     *                                       respectively.
     *                                       If an object, the id/name properties
     *                                       will used as the option tag's
     *                                       value/label respectively.
     *                                       If null, and empty Select element
     *                                       will be returned.
     * @param string[optional] $entity       The the model and field name as
     *                                       period separated string (e.g.,
     *                                       'user.name').
     * @param mixed[optional]  $default      The default value to select.
     * @param array[optional]  $attributes   An array of HTML attributes.
     * @param mixed[optional]  $initialLabel An initial label to show as the
     *                                       first option in the list.
     *
     * @access public
     * @return string
     */
    public function formDropdown(
        $options = null,
        $entity = '',
        $default = null,
        array $attributes = array(),
        $initialLabel = null
    ) {
        if ($entity != '') {
            list($model, $field) = explode('.', $entity);

            $attributes['name'] = $model . '[' . $field . ']';
            $attributes['id'] = $model . '_' . $field;
        }

        if (is_null($options)) {
            $options = array();
        }

        $return = '<select' . $this->attributes($attributes) . '>';

        if ($initialLabel !== null) {
            $option = array('value' => '');

            if (is_null($default)) {
                $option['selected'] = 'selected';
            }

            $return .= '<option' . $this->attributes($option) . '>' . $initialLabel . '</option>';
        }

        if (is_object($options)) {
            foreach ($options as $obj) {
                $option = array('value' => $obj->id);

                if ($default == $obj->id) {
                    $option['selected'] = 'selected';
                }

                $return .= '<option' . $this->attributes($option) . '>' . $obj->name . '</option>';
            }
        } else {
            foreach ($options as $value => $label) {
                $option = array('value' => $value);

                if ($default == $value) {
                    $option['selected'] = 'selected';
                }

                $return .= '<option' . $this->attributes($option) . '>' . $label . '</option>';
            }
        }

        return $return . '</select>';
    }
}

