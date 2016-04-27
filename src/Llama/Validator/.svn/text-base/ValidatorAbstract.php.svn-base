<?php
namespace Llama\Validator;

/**
 * Abstract Validator class for use in Llama\Validator.
 *
 * @category Llama
 * @package  Validator
 * @author   Brendan Smith <brendan.s@crazydomains.com>
 * @version  1.0
 * @abstract
 */
abstract class ValidatorAbstract
{

    /**
     * The default validator configuration.
     *
     * @access protected
     * @var    array
     */
    protected $config = array(
        'allow_blank' => false,
        'allow_nil' => false,
        'if' => true,
        'unless' => false,
        'on' => 'save'
    );

    /**
     * Return the validation config for a field.
     *
     * @param string $field           The name of the field being validated.
     * @param array  $specifiedConfig The config specific to the field.
     * @param array  $defaultConfig   The config specific to the validation method.
     *
     * @access protected
     * @return array
     */
    protected function prepareValidationData($field, $specifiedConfig, $defaultConfig)
    {
        if (!is_array($specifiedConfig)) {

            //it is not required to specify the config, if this is the case (the
            //config is not an array) then the field name has been passed in the
            //config's position, so we will convert it to the field, and set the
            //config to the default config.
            return array($specifiedConfig, $defaultConfig);
        }

        return array($field, empty($specifiedConfig) ? $defaultConfig : array_merge($defaultConfig, $specifiedConfig));
    }

    /**
     * Pluralise a given word if the $count parameter is not 1.
     *
     * @param string $countType The word to pluralise.
     * @param int    $count     The count to determine if the word is to be
     *                          pluralised.
     *
     * @access protected
     * @return string
     */
    protected function pluralise($countType, $count)
    {
        if ($count != 1) {
            return $countType . 's';
        }

        return $countType;
    }
}

