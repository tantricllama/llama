<?php
namespace Llama;

use Llama\Validator\Exception;
use Llama\Validator\FormatOf;
use Llama\Validator\InclusionOf;
use Llama\Validator\LengthOf;
use Llama\Validator\NumericalityOf;
use Llama\Validator\PresenceOf;
use Llama\Validator\ValidatorInterface;

/**
 * Validator class for use in Llama.
 *
 * @category Llama
 * @package  Validator
 * @author   Brendan Smith <brendan.s@crazydomains.com>
 * @version  1.0
 *
 * @todo Allow mapping of configuration options such as "in" to helper methods
 *       WITHOUT calling the methods on instantiation.
 * @todo The configuration options "if" and "unless" need to be able to reference
 *       the results of future validation tests.
 * @todo Add the ability to compose values (e.g. date_of_birth => [year, month,
 *       day]).
 *
 * @uses \Llama\Validator\FormatOf
 * @uses \Llama\Validator\InclusionOf
 * @uses \Llama\Validator\LengthOf
 * @uses \Llama\Validator\NumericalityOf
 * @uses \Llama\Validator\PresenceOf
 * @uses \Llama\Validator\ValidatorInterface
 */
class Validator implements ValidatorInterface
{

    /**
     * A field=>config array for the formatOf validation.
     *
     * @access protected
     * @var    array
     */
    protected $formatOf = array();

    /**
     * A field=>config array for the inclusionOf validation.
     *
     * @access protected
     * @var    array
     */
    protected $inclusionOf = array();

    /**
     * A field=>config array for the lengthOf validation.
     *
     * @access protected
     * @var    array
     */
    protected $lengthOf = array();

    /**
     * A field=>config array for the numericalityOf validation.
     *
     * @access protected
     * @var    array
     */
    protected $numericalityOf = array();

    /**
     * A field=>config array for the presenceOf validation.
     *
     * @access protected
     * @var    array
     */
    protected $presenceOf = array();

    /**
     * A field=>field_name array (e.g., array('first_name' => 'First Name')).
     *
     * @access protected
     * @var    array
     */
    protected $fields = array();

    /**
     * A field=>value array to be validated.
     *
     * @access protected
     * @var    array
     */
    protected $data = array();

    /**
     * A field=>errors[] array of validation errors.
     *
     * @access protected
     * @var    array
     */
    protected $errors = array();

    /**
     * The validation mode; create or update.
     *
     * @access protected
     * @var    string
     */
    protected $mode;

    /**
     * Run all configured validation over the supplied data.
     *
     * @param array $data The data to be validated.
     *
     * @access public
     * @throws \Llama\Validator\Exception
     * @return void
     */
    public function execute(array $data = array())
    {
        if (is_null($this->mode)) {
            throw new Exception('Validation mode has not been set');
        }

        if (!empty($data)) {
            $this->setData($data);
        }

        if (!empty($this->formatOf)) {
            new FormatOf($this);
        }

        if (!empty($this->inclusionOf)) {
            new InclusionOf($this);
        }

        if (!empty($this->lengthOf)) {
            new LengthOf($this);
        }

        if (!empty($this->numericalityOf)) {
            new NumericalityOf($this);
        }

        if (!empty($this->presenceOf)) {
            new PresenceOf($this);
        }
    }

    /**
     * Set the validation mode to create.
     *
     * @access public
     * @return void
     */
    public function setCreateMode()
    {
        $this->mode = 'create';
    }

    /**
     * Set the validation mode to update.
     *
     * @access public
     * @return void
     */
    public function setUpdateMode()
    {
        $this->mode = 'update';
    }

    /**
     * Return the validation mode.
     *
     * @access public
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Set the data to be validated.
     *
     * @param array $data An array of data to be validated.
     *
     * @access public
     * @return void
     */
    public function setData(array $data)
    {
        $this->data = array_intersect_key($data, $this->fields);
    }

    /**
     * Return the data to be validated.
     *
     * @access public
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the fields to be validated.
     *
     * @param array $fields The fields to be validated.
     *
     * @access public
     * @return void
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;
    }

    /**
     * Return the fields to be validated.
     *
     * @access public
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Set the config for the formatOf validation.
     *
     * @param array $formatOf The config for the formatOf validation.
     *
     * @access public
     * @return void
     */
    public function setFormatOf(array $formatOf)
    {
        $this->formatOf = $formatOf;
    }

    /**
     * Return the config for the formatOf validation.
     *
     * @access public
     * @return array
     */
    public function getFormatOf()
    {
        return $this->formatOf;
    }

    /**
     * Set the config for the inclusionOf validation.
     *
     * @param array $inclusionOf The config for the inclusionOf validation.
     *
     * @access public
     * @return void
     */
    public function setInclusionOf(array $inclusionOf)
    {
        $this->inclusionOf = $inclusionOf;
    }

    /**
     * Return the config for the inclusionOf validation.
     *
     * @access public
     * @return array
     */
    public function getInclusionOf()
    {
        return $this->inclusionOf;
    }

    /**
     * Set the config for the lengthOf validation.
     *
     * @param array $lengthOf The config for the lengthOf validation.
     *
     * @access public
     * @return void
     */
    public function setLengthOf(array $lengthOf)
    {
        $this->lengthOf = $lengthOf;
    }

    /**
     * Return the config for the lengthOf validation.
     *
     * @access public
     * @return array
     */
    public function getLengthOf()
    {
        return $this->lengthOf;
    }

    /**
     * Set the config for the numericalityOf validation.
     *
     * @param array $numericalityOf The config for the numericalityOf validation.
     *
     * @access public
     * @return void
     */
    public function setNumericalityOf(array $numericalityOf)
    {
        $this->numericalityOf = $numericalityOf;
    }

    /**
     * Return the config for the numericalityOf validation.
     *
     * @access public
     * @return array
     */
    public function getNumericalityOf()
    {
        return $this->numericalityOf;
    }

    /**
     * Set the config for the presenceOf validation.
     *
     * @param array $presenceOf The config for the presenceOf validation.
     *
     * @access public
     * @return void
     */
    public function setPresenceOf(array $presenceOf)
    {
        $this->presenceOf = $presenceOf;
    }

    /**
     * Return the config for the presenseOf validation.
     *
     * @access public
     * @return array
     */
    public function getPresenceOf()
    {
        return $this->presenceOf;
    }

    /**
     * Add a validation error.
     *
     * @param string $item  The item the error has occurred on.
     * @param string $error The error message.
     *
     * @access public
     * @return void
     */
    public function addError($item, $error)
    {
        if (!isset($this->errors[$item])) {
            $this->errors[$item] = array();
        }

        $this->errors[$item][] = $error;
    }

    /**
     * Return true if an error has occurred, false otherwise.
     *
     * @access public
     * @return bool
     */
    public function hasErrors()
    {
        return !empty($this->errors);
    }

    /**
     * Return the validation errors.
     *
     * @access public
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}

