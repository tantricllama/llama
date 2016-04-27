<?php
namespace Llama\Validator;

/**
 * Validator Interface for use in Llama\Validator.
 *
 * @category    Llama
 * @package     Validator
 * @author      Brendan Smith <brendan.s@crazydomains.com>
 * @version     1.0
 * @abstract
 */
interface ValidatorInterface
{

    /**
     * Set the validation mode to create.
     *
     * @access public
     * @return void
     */
    public function setCreateMode();

    /**
     * Set the validation mode to update.
     *
     * @access public
     * @return void
     */
    public function setUpdateMode();

    /**
     * Return the validation mode.
     *
     * @access public
     * @return string
     */
    public function getMode();

    /**
     * Set the data to be validated.
     *
     * @param array $data An array of data to be validated.
     *
     * @access public
     * @return void
     */
    public function setData(array $data);

    /**
     * Return the data to be validated.
     *
     * @access public
     * @return array
     */
    public function getData();

    /**
     * Set the fields to be validated.
     *
     * @param array $fields The fields to be validated.
     *
     * @access public
     * @return void
     */
    public function setFields(array $fields);

    /**
     * Return the fields to be validated.
     *
     * @access public
     * @return array
     */
    public function getFields();

    /**
     * Set the config for the formatOf validation.
     *
     * @param array $formatOf The config for the formatOf validation.
     *
     * @access public
     * @return void
     */
    public function setFormatOf(array $formatOf);

    /**
     * Return the config for the formatOf validation.
     *
     * @access public
     * @return array
     */
    public function getFormatOf();

    /**
     * Set the config for the inclusionOf validation.
     *
     * @param array $inclusionOf The config for the inclusionOf validation.
     *
     * @access public
     * @return void
     */
    public function setInclusionOf(array $inclusionOf);

    /**
     * Return the config for the inclusionOf validation.
     *
     * @access public
     * @return array
     */
    public function getInclusionOf();

    /**
     * Set the config for the lengthOf validation.
     *
     * @param array $lengthOf The config for the lengthOf validation.
     *
     * @access public
     * @return void
     */
    public function setLengthOf(array $lengthOf);

    /**
     * Return the config for the lengthOf validation.
     *
     * @access public
     * @return array
     */
    public function getLengthOf();

    /**
     * Set the config for the numericalityOf validation.
     *
     * @param array $numericalityOf The config for the numericalityOf validation.
     *
     * @access public
     * @return void
     */
    public function setNumericalityOf(array $numericalityOf);

    /**
     * Return the config for the numericalityOf validation.
     *
     * @access public
     * @return array
     */
    public function getNumericalityOf();

    /**
     * Set the config for the presenceOf validation.
     *
     * @param array $presenceOf The config for the presenceOf validation.
     *
     * @access public
     * @return void
     */
    public function setPresenceOf(array $presenceOf);

    /**
     * Return the config for the presenseOf validation.
     *
     * @access public
     * @return array
     */
    public function getPresenceOf();

    /**
     * Add a validation error.
     *
     * @param string $item  The item the error has occurred on.
     * @param string $error The error message.
     *
     * @access public
     * @return void
     */
    public function addError($item, $error);

    /**
     * Return true if an error has occurred, false otherwise.
     *
     * @access public
     * @return bool
     */
    public function hasErrors();

    /**
     * Return the validation errors.
     *
     * @access public
     * @return array
     */
    public function getErrors();
}

