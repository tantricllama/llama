<?php
namespace Llama\Validator;

use Llama\Validator\ValidatorInterface;

/**
 * NumericalityOf class for use in Llama\Validator.
 *
 * @category Llama
 * @package  Validator
 * @author   Brendan Smith <brendan.s@crazydomains.com>
 * @version  1.0
 *
 * @uses \Llama\Validator\ValidatorInterface
 */
class NumericalityOf extends ValidatorAbstract
{

    /**
     * Constructor
     *
     * Setup the NumericalityOf object and validate each field.
     *
     * @param ValidatorInterface $validator The validator object.
     *
     * @access public
     */
    public function __construct(ValidatorInterface $validator)
    {
        $defaultConfig = array(
            'message' => '%s is not a number',
            'integer_message' => '%s is not an integer',
            'greater_than_message' => '%s is not greater than %d',
            'greater_than_or_equal_to_message' => '%s is not greater than or equal to %d',
            'equal_to_message' => '%s is not equal to %d',
            'less_than_message' => '%s is not less than %d',
            'less_than_or_equal_to_message' => '%s is not less than or equal to %d',
            'only_integer' => false
        );
        $defaultConfig = array_merge($this->config, $defaultConfig);
        $fields = $validator->getFields();
        $data = $validator->getData();

        foreach ($validator->getNumericalityOf() as $field => $config) {
            list($field, $config) = $this->prepareValidationData($field, $config, $defaultConfig);

            if (!isset($data[$field])) {
                if ($config['allow_nil']) {
                    continue;
                }

                $data[$field] = '';
            }

            if (!$config['if'] ||
                $config['unless'] ||
                ($config['on'] != 'save' && $config['on'] != $validator->getMode())
            ) {
                continue;
            }

            if (!is_numeric($data[$field])) {
                $validator->addError($field, sprintf($config['message'], $fields[$field]));

                //there is a chance that the field is empty, in which case the field will be treated
                //as zero in the loose comparison operations
                continue;
            }

            if ($config['only_integer'] && !is_integer($data[$field])) {
                $validator->addError(
                    $field,
                    sprintf(
                        $config['integer_message'],
                        $fields[$field]
                    )
                );
            }

            if (isset($config['greater_than']) && $data[$field] <= $config['greater_than']) {
                $validator->addError(
                    $field,
                    sprintf(
                        $config['greater_than_message'],
                        $fields[$field],
                        $config['greater_than']
                    )
                );
            }

            if (isset($config['greater_than_or_equal_to']) && $data[$field] < $config['greater_than_or_equal_to']) {
                $validator->addError(
                    $field,
                    sprintf(
                        $config['greater_than_or_equal_to_message'],
                        $fields[$field],
                        $config['greater_than_or_equal_to']
                    )
                );
            }

            if (isset($config['equal_to']) && $data[$field] != $config['equal_to']) {
                $validator->addError(
                    $field,
                    sprintf(
                        $config['equal_to_message'],
                        $fields[$field],
                        $config['equal_to']
                    )
                );
            }

            if (isset($config['less_than']) && $data[$field] >= $config['less_than']) {
                $validator->addError(
                    $field,
                    sprintf(
                        $config['less_than_message'],
                        $fields[$field],
                        $config['less_than']
                    )
                );
            }

            if (isset($config['less_than_or_equal_to']) && $data[$field] > $config['less_than_or_equal_to']) {
                $validator->addError(
                    $field,
                    sprintf(
                        $config['less_than_or_equal_to_message'],
                        $fields[$field],
                        $config['less_than_or_equal_to']
                    )
                );
            }
        }
    }
}

