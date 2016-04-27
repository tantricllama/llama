<?php
namespace Llama\Model;

/**
 * Abstract Collection class for use in Llama\Model.
 *
 * @category   Llama
 * @package    Model
 * @subpackage Collection
 * @author     Brendan Smith <brendan.s@crazydomains.com>
 * @version    1.0
 * @abstract
 *
 * @uses \Iterator
 * @uses \Countable
 * @uses \ArrayAccess
 */
abstract class CollectionAbstract implements \Iterator, \Countable, \ArrayAccess
{

    /**
     * An array of instantiated models.
     *
     * @access protected
     * @var    array
     */
    protected $models;

    /**
     * An executed PDO statement object.
     *
     * @access protected
     * @var    \PDOStatement
     */
    protected $records;

    /**
     * The internal pointer of the record set.
     *
     * @access protected
     * @var    int
     */
    protected $index;

    /**
     * Determines if the next method is to be skipped after
     * unsetting a value from the models property.
     *
     * @access protected
     * @var    bool
     */
    protected $skipNextIteration;

    /**
     * @access protected
     * @var    \Llama\Model\Mapper\MapperAbstract
     */
    protected $mapper;

    /**
     * Constructor
     *
     * Set up the Collection and assign the mapper.
     *
     * @param \Llama\Model\Mapper\MapperAbstract $mapper  Mapper used to retrieve
     *                                                    records.
     * @param \PDOStatement[optional]            $records An optional executed
     *                                                    PDO statement.
     *
     * @access public
     */
    public function __construct($mapper, \PDOStatement $records = null)
    {
        $this->mapper = $mapper;
        $this->records = $records;
        $this->models = array();
        $this->index = 0;
    }


    /**
     * Determine if the position in the records property is valid.
     *
     * @param string $name The name of the field to retrieve from each model.
     *
     * @access public
     * @return array
     */
    public function fetchField($name)
    {
        $return = array();

        foreach ($this as $model) {
            $return[] = $model->$name;
        }

        return $return;
    }

    /**
     * Return the instantiated model identified by the primary key at the offset.
     *
     * @param mixed $offset The offset of the model to retrieve.
     *
     * @access public
     * @return \Llama\Model\ModelAbstract
     */
    private function retrieveModel($offset)
    {
        if (!isset($this->models[$offset])) {
            $this->records->setFetchMode(\PDO::FETCH_CLASS, $this->modelNamespace);

            $this->models[$offset] = $this->records->fetch(\PDO::FETCH_CLASS, \PDO::FETCH_ORI_ABS, $offset);
            $this->models[$offset]->setMapper($this->mapper);
        }

        return $this->models[$offset];
    }

    // -- SPL Methods

    /**
     * Return the number of models in the collection.
     *
     * @see \Countable::count()
     *
     * @access public
     * @return int
     */
    public function count()
    {
        return is_null($this->records) ? 0 : $this->records->rowCount();
    }

    /**
     * Determine if the offset exists in the models property.
     *
     * @param int $offset The offset used to determine if the model exists.
     *
     * @see \ArrayAccess::offsetExists()
     *
     * @access public
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->models[$offset]);
    }

    /**
     * Return the value at the offset from the models property.
     *
     * @param int $offset The offset of the model to return.
     *
     * @see \ArrayAccess::offsetGet()
     *
     * @access public
     * @return \Llama\Model\ModelAbstract|null
     */
    public function offsetGet($offset)
    {
        return $offset < $this->count() ? $this->retrieveModel($offset) : null;
    }

    /**
     * Add a value to the models property at the specified offset.
     *
     * @param int|null                   $offset The offset to assign the model to.
     * @param \Llama\Model\ModelAbstract $value  The model to assign.
     *
     * @see \ArrayAccess::offsetSet()
     *
     * @access public
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->models[] = $value;
        } else {
            $this->models[$offset] = $value;
        }
    }

    /**
     * Remove the value at the offset from the models property.
     *
     * @param int $offset The offset of the model to remove.
     *
     * @see \ArrayAccess::offsetUnset()
     *
     * @access public
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->models[$offset]);

        $this->skipNextIteration = true;
    }

    /**
     * Return the current model.
     *
     * @see \Iterator::current()
     *
     * @access public
     * @return \Llama\Model\ModelAbstract
     */
    public function current()
    {
        $this->skipNextIteration = false;

        return $this->retrieveModel($this->index);
    }

    /**
     * Return the internal pointer.
     *
     * @see \Iterator::key()
     *
     * @access public
     * @return int
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * Move the internal pointer to the next value.
     *
     * @see \Iterator::next()
     *
     * @access public
     * @return void
     */
    public function next()
    {
        if ($this->skipNextIteration) {
            $this->skipNextIteration = false;

            return;
        }

        $this->index++;
    }

    /**
     * Reset the collections internal pointer.
     *
     * @see \Iterator::rewind()
     *
     * @access public
     * @return void
     */
    public function rewind()
    {
        $this->skipNextIteration = false;
        $this->index = 0;
    }

    /**
     * Determine if the position in the records property is valid.
     *
     * @see \Iterator::valid()
     *
     * @access public
     * @return bool
     */
    public function valid()
    {
        return $this->index < $this->count();
    }

    // -- Magic Methods

    /**
     * Call a method to retrieve the record set. The sub class acts a proxy:
     *
     * PhotoCollection->findByPhotographer
     *
     * @param string $method    The name of the method to call.
     * @param array  $arguments The arguments to pass to the method.
     *
     * @access public
     * @return void
     */
    public function __call($method, $arguments)
    {
        echo "$method<br />";

        if (strpos($method, 'find') !== 0 ||
            !method_exists($this->mapper, $method) ||
            !is_callable(array($this->mapper, $method))) {
            throw new \BadMethodCallException("Invalid selector method '$method'");
        }

        $this->records = call_user_func_array(array($this->mapper, $method), $arguments);
    }

    /**
     * Returns the collection as a comma separated string, by iterating over
     * the models array and calling the __toString method of each model.
     *
     * @access public
     * @return string
     */
    public function __toString()
    {
        $return = array();

        foreach ($this as $model) {
            $return[] = $model->__toString();
        }

        return implode(', ', $return);
    }
}

