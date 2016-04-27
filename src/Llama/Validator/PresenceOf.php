<?php
namespace Llama\Validator;

use Llama\Validator\ValidatorInterface;

/**
 * PresenceOf class for use in Llama\Validator.
 *
 * @category Llama
 * @package  Validator
 * @author   Brendan Smith <brendan.s@crazydomains.com>
 * @version  1.0
 *
 * @uses \Llama\Validator\ValidatorInterface
 */
class PresenceOf extends ValidatorAbstract
{

    /**
     * Constructor
     *
     * Setup the PresenceOf object and validate each field.
     *
     * @param ValidatorInterface $validator The validator object.
     *
     * @access public
     */
    public function __construct(ValidatorInterface $validator)
    {
        $defaultConfig = array(
            'message' => '%s is required'
        );
        $defaultConfig = array_merge($this->config, $defaultConfig);
        $fields = $validator->getFields();
        $data = $validator->getData();

        foreach ($validator->getPresenceOf() as $field => $config) {
            list($field, $config) = $this->prepareValidationData($field, $config, $defaultConfig);

            if (!$config['if'] ||
                $config['unless'] ||
                ($config['on'] != 'save' && $config['on'] != $validator->getMode())
            ) {
                continue;
            }

            if (!isset($data[$field]) || $data[$field] == '') {
                $validator->addError($field, sprintf($config['message'], $fields[$field]));
            }
        }
    }
}

