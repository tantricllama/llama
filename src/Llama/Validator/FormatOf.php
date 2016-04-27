<?php
namespace Llama\Validator;

use Llama\Validator\ValidatorInterface;

/**
 * FormatOf class for use in Llama\Validator.
 *
 * @category Llama
 * @package  Validator
 * @author   Brendan Smith <brendan.s@crazydomains.com>
 * @version  1.0
 *
 * @uses \Llama\Validator\ValidatorInterface
 */
class FormatOf extends ValidatorAbstract
{

    /**
     * Constructor
     *
     * Setup the FormatOf object and validate each field.
     *
     * @param ValidatorInterface $validator The validator object.
     *
     * @access public
     */
    public function __construct(ValidatorInterface $validator)
    {
        $defaultConfig = array(
            'message' => '%s is invalid'
        );
        $defaultConfig = array_merge($this->config, $defaultConfig);
        $fields = $validator->getFields();
        $data = $validator->getData();

        foreach ($validator->getFormatOf() as $field => $config) {
            list($field, $config) = $this->prepareValidationData($field, $config, $defaultConfig);

            if (!isset($data[$field])) {
                if ($config['allow_nil']) {
                    continue;
                }

                $data[$field] = '';
            }

            if (($config['allow_blank'] && $data[$field] == '') ||
                !$config['if'] ||
                $config['unless'] ||
                ($config['on'] != 'save' && $config['on'] != $validator->getMode())
            ) {
                continue;
            }

            if (!preg_match($config['regex'], $data[$field])) {
                $validator->addError($field, sprintf($config['message'], $fields[$field]));
            }
        }
    }
}

