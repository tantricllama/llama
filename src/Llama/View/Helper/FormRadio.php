<?php
namespace Llama\View\Helper;

/**
 * FormRadio class for use in Llama\View\Helper.
 *
 * @category   Llama
 * @package    View
 * @subpackage Helper
 * @author     Brendan Smith <brendan.s@crazydomains.com>
 * @version    1.0
 *
 * @uses \Llama\View\Helper\FormElementAbstract
 */
class FormRadio extends FormElementAbstract
{

    /**
     * Generate a group of HTML Radio elements.
     *
     * @param array            $items         An array of items used to create
     *                                        the checkboxes, for example:
     *                                        [
     *                                          0 => 'Private',
     *                                          1 => 'Public'
     *                                        ]
     *                                        or:
     *                                        [
     *                                          'yes' => 'Yes',
     *                                          'no' => 'No'
     *                                        ]
     * @param string[optional] $entity        The the model and field name as
     *                                        period separated string (e.g.,
     *                                        'user.name').
     * @param array[optional]  $attributes    An array of HTML attributes.
     * @param array[optional]  $selectedItems An array of items to mark as
     *                                        selected.
     *
     * @access public
     * @return string
     */
    public function formRadio(array $items, $entity = '', array $attributes = array(), $selectedItems = null)
    {
        $attributes['type'] = 'radio';

        if ($entity != '') {
            list($model, $field) = explode('.', $entity);

            $attributes['name'] = $model . '[' . $field . ']';
            $attributes['id'] = $model . '_' . $field;
        }

        if (is_null($selectedItems)) {
            $selectedItems = array();
        } elseif (!is_array($selectedItems)) {
            $selectedItems = array($selectedItems);
        }

        $return = '';
        $originalId = $attributes['id'];

        foreach ($items as $value => $label) {
            $inputAttributes = $attributes;
            $inputAttributes['value'] = $value;
            $inputAttributes['id'] = $originalId . '_' . $value;

            if (in_array($value, $selectedItems)) {
                $inputAttributes['checked'] = 'checked';
            }

            $return .= '<label class="radio">
    <input' . $this->attributes($inputAttributes) . '> ' . $label . '
</label>
';
        }

        return $return;
    }
}

