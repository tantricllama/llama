<?php
namespace Llama\Validator;

use Llama\Validator\ValidatorInterface;

/**
 * LengthOf class for use in Llama\Validator.
 *
 * @category Llama
 * @package  Validator
 * @author   Brendan Smith <brendan.s@crazydomains.com>
 * @version  1.0
 *
 * @uses \Llama\Validator\ValidatorInterface
 */
class LengthOf extends ValidatorAbstract
{

    /**
     * Constructor
     *
     * Setup the LengthOf object and validate each field.
     *
     * @param ValidatorInterface $validator The validator object.
     *
     * @access public
     */
    public function __construct(ValidatorInterface $validator)
    {
        $defaultConfig = array(
            'is_equal_to_message' => '%s is the wrong length (should be %d %s)',
            'between_message' => '%s must be between %d and %d %s',
            'minimum_message' => '%s must be more than %d %s',
            'maximum_message' => '%s must be less than %d %s',
            'word_count' => false
        );
        $defaultConfig = array_merge($this->config, $defaultConfig);
        $fields = $validator->getFields();
        $data = $validator->getData();

        foreach ($validator->getLengthOf() as $field => $config) {
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

            if ($config['word_count']) {
                $length = $data[$field] != '' ? sizeof(explode(' ', $data[$field])) : 0;
                $count_type = 'word';
            } else {
                $length = strlen($data[$field]);
                $count_type = 'character';
            }

            if (isset($config['is_equal_to']) && $length != $config['is_equal_to']) {
                $validator->addError(
                    $field,
                    sprintf(
                        $config['is_equal_to_message'],
                        $fields[$field],
                        $config['is_equal_to'],
                        $this->pluralise(
                            $count_type,
                            $config['is_equal_to']
                        )
                    )
                );
            } else {
                if (isset($config['minimum'], $config['maximum']) &&
                    ($length < $config['minimum'] || $length > $config['maximum'])
                ) {
                    $validator->addError(
                        $field,
                        sprintf(
                            $config['between_message'],
                            $fields[$field],
                            $config['minimum'],
                            $config['maximum'],
                            $this->pluralise(
                                $count_type,
                                2
                            )
                        )
                    );
                } elseif (isset($config['minimum']) && ($length < $config['minimum'])) {
                    $validator->addError(
                        $field,
                        sprintf(
                            $config['minimum_message'],
                            $fields[$field],
                            $config['minimum'],
                            $this->pluralise(
                                $count_type,
                                $config['minimum']
                            )
                        )
                    );
                } elseif (isset($config['maximum']) && ($length > $config['maximum'])) {
                    $validator->addError(
                        $field,
                        sprintf(
                            $config['maximum_message'],
                            $fields[$field],
                            $config['maximum'],
                            $this->pluralise(
                                $count_type,
                                $config['maximum']
                            )
                        )
                    );
                }
            }
        }
    }
}

