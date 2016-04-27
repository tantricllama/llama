<?php
namespace Llama;

/**
 * Configuration class for use in Llama.
 *
 * @category Llama
 * @package  Configuration
 * @author   Brendan Smith <brendan.s@crazydomains.com>
 * @version  1.0
 *
 * @uses \Countable
 * @uses \Iterator
 */
class Configuration implements \Countable, \Iterator
{

    /**
     * The internal pointer.
     *
     * @access protected
     * @var    int
     */
    protected $index;

    /**
     * The data array.
     *
     * @access protected
     * @var    mixed
     */
    protected $data;

    /**
     * The size of the data array.
     *
     * @access protected
     * @var    int
     */
    protected $count;

    /**
     * Determines if the next method is to be skipped after unsetting a value
     * from the data array.
     *
     * @access protected
     * @var    bool
     */
    protected $skipNextIteration;

    /**
     * Constructor
     *
     * Sets up the Configuration object.
     *
     * @param array $array An array of configuration data.
     *
     * @access public
     * @return void
     */
    public function __construct(array $array)
    {
        $this->index = 0;
        $this->data = array();

        foreach ($array as $name => $value) {
            if (is_array($value)) {
                $this->data[$name] = new self($value);
            } else {
                $this->data[$name] = $value;
            }
        }

        $this->count = sizeof($this->data);
    }

    /**
     * Return the size of the data array.
     *
     * @access public
     * @return int
     */
    public function count()
    {
        return $this->count;
    }

    /**
     * Reset the internal pointer of the data array.
     *
     * @access public
     * @return void
     */
    public function rewind()
    {
        reset($this->data);

        $this->index = 0;
        $this->skipNextIteration = false;
    }

    /**
     * Return the current value of data array.
     *
     * @access public
     * @return mixed
     */
    public function current()
    {
        $this->skipNextIteration = false;

        return current($this->data);
    }

    /**
     * Return the current key of the data array.
     *
     * @access public
     * @return mixed
     */
    public function key()
    {
        return key($this->data);
    }

    /**
     * Move the internal pointer to the next value in data array.
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

        next($this->data);

        $this->index++;
    }

    /**
     * Determine if the position in the data array is valid.
     *
     * @access public
     * @return bool
     */
    public function valid()
    {
        return $this->index < $this->count;
    }

    /**
     * Return a value from the data array. If no key is found, the specifed
     * default value is returned.
     *
     * @param string           $name    The name of the value to return from the data array.
     * @param string[optional] $default An optional value to return if the name is not found.
     *
     * @access public
     * @return mixed
     */
    public function get($name, $default = null)
    {
        if (!array_key_exists($name, $this->data)) {
            return $default;
        }

        return $this->data[$name];
    }

    /**
     * Merges 2 arrays, if the arrays are found to have the same keys, the second
     * array value will overwrite the first.
     *
     * @param mixed $firstArray  The array to merge into.
     * @param mixed $secondArray The array to merge from.
     *
     * @access protected
     * @return array
     */
    protected function arrayMergeRecursive($firstArray, $secondArray)
    {
        foreach ($secondArray as $key => $value) {
            if (isset($firstArray[$key])) {
                $firstArray[$key] = $this->arrayMergeRecursive($firstArray[$key], $value);
            } else {
                $firstArray[$key] = $secondArray[$key];
            }
        }

        return $firstArray;
    }

    // -- Magic Methods

    /**
     * Return a value from the data array.
     *
     * @param string $name The name of the value to return from the data array.
     *
     * @access public
     * @return mixed
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * Determine if a value is set in the data array.
     *
     * @param string $name The name of the value to look for in the data array.
     *
     * @access public
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    /**
     * Remove a value from the data array.
     *
     * @param string $name The name of the value to remove from the data array.
     *
     * @access public
     * @return void
     */
    public function __unset($name)
    {
        unset($this->data[$name]);

        $this->count = sizeof($this->data);
        $this->skipNextIteration = true;
    }
}

