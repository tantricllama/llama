<?php
namespace Llama\Model;

use Llama\Model\Mapper\MapperAbstract;
use \InvalidArgumentException;

/**
 * Abstract Model class for use in Llama\Model.
 *
 * @category Llama
 * @package  Model
 * @author   Brendan Smith <brendan.s@crazydomains.com>
 * @version  1.0
 * @abstract
 *
 * @uses \Llama\Model\Mapper\MapperAbstract
 * @uses \InvalidArgumentException
 */
abstract class ModelAbstract
{

    /**
     * @access protected
     * @var    array
     */
    protected $data;

    /**
     * @access protected
     * @var    \Llama\Model\Mapper\MapperAbstract
     */
    protected $mapper;

    /**
     * Constructor
     *
     * Set up the Model and assign the mapper.
     *
     * @param \Llama\Model\Mapper\MapperAbstract[optional] $mapper The data mapper.
     *
     * @access public
     */
    public function __construct(MapperAbstract $mapper = null)
    {
        $this->mapper = $mapper;
    }

    /**
     * Assign a mapper to the mapper property.
     *
     * @param \Llama\Model\Mapper\MapperAbstract $mapper The data mapper.
     *
     * @access public
     * @return void
     */
    public function setMapper($mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * Load a reference. For a has-one relationship load the references model,
     * for a has-many relationship load the references collection.
     *
     * @param string $reference The name of the reference to load.
     *
     * @access protected
     * @return \Llama\Model\ModelAbstract|\Llama\Model\CollectionAbstract
     */
    protected function loadReference($reference)
    {
        extract($this->data[$reference]);

        //if the reference has been loaded already we can simply return the value
        if ($loaded) {
            return $value;
        }

        $mapperObj = new $mapper($this->mapper->getAdapter());

        if ($cardinality == 'has-one') {
            $value = $mapperObj->findById($this->$foreignKey);
        } elseif ($cardinality == 'has-many') {
            $value = $mapperObj->$method($this);
        } else {
            throw new \InvalidArgumentException("Invalid cardinality '$cardinality' for '$reference' reference");
        }

        $this->data[$reference]['value'] = $value;
        $this->data[$reference]['loaded'] = true;

        return $value;
    }

    /**
     * Format a field name as such:
     *
     * field_name -> fieldName
     *
     * @param string $name The name of the field.
     *
     * @access public
     * @return string
     */
    private function formatFieldName($name)
    {
        $parts = explode('_', $name, 2);
        $return = $parts[0];

        if (sizeof($parts) > 1) {
            $return .= str_replace(' ', '', ucwords(str_replace('_', ' ', $parts[1])));
        }

        return $return;
    }

    // -- Magic Methods

    /**
     * Map the setting of non-existing fields to a mutator when possible,
     * otherwise use the matching field.
     *
     * @param string $name  The name of the field to assign the value to.
     * @param mixed  $value The value to assign.
     *
     * @access public
     * @throws \InvalidArgumentException
     * @return void
     */
    public function __set($name, $value)
    {
        $field = $this->formatFieldName($name);
        $mutator = 'set' . ucfirst($field);

        if (!method_exists($this, $mutator) || !is_callable(array($this, $mutator))) {
            throw new \InvalidArgumentException("Setting the field '$name' is not valid for this entity.");
        }

        $this->$mutator($value);
    }

    /**
     * Map the getting of non-existing properties to an accessor when possible,
     * otherwise use the matching field
     *
     * @param string $name The name of the field retrieve.
     *
     * @access public
     * @throws \InvalidArgumentException
     * @return mixed
     */
    public function __get($name)
    {
        $field = $this->formatFieldName($name);
        $accessor = 'get' . ucfirst($field);

        if (!method_exists($this, $accessor) || !is_callable(array($this, $accessor))) {
            throw new \InvalidArgumentException("Getting the field '$name' is not valid for this entity.");
        }

        return $this->$accessor();
    }

    /**
     * Tell serialize() which properties to serialize
     *
     * @access public
     * @return array
     */
    public function __sleep()
    {
        return array('data');
    }

    /**
     * Return a string representation of the object.
     *
     * @abstract
     * @access   public
     * @return   string
     */
    abstract public function __toString();
}

