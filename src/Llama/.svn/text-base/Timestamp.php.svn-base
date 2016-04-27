<?php
namespace Llama;

/**
 * Timestamp object used to store a formattable timestamp.
 *
 * @category Llama
 * @package  Timestamp
 * @author   Brendan Smith <brendan.s@crazydomains.com>
 * @version  1.0
 */
class Timestamp
{

    /**
     * The default format.
     *
     * @var string
     */
    const DEFAULT_FORMAT = 'j M y';

    /**
     * A unix timestamp.
     *
     * @static
     * @access private
     * @var    int
     */
    private $timestamp;

    /**
     * The format used when outputting the timestamp.
     *
     * @access private
     * @var    string
     */
    private $format;

    /**
     * Constructor
     *
     * Set up the object and save the timestamp internally.
     *
     * @param int|string[optional] $timestamp The unix timestamp.
     *
     * @access public
     * @throws \InvalidArgumentException
     */
    public function __construct($timestamp = '')
    {
        $this->setTimestamp($timestamp);
    }

    /**
     * Set the format.
     *
     * @param string $format The format string, using PHP's date format.
     *
     * @access public
     * @return \Llama\Timestamp
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Return the format string.
     *
     * @access public
     * @return string
     */
    public function getFormat()
    {
        return is_null($this->format) ? self::DEFAULT_FORMAT : $this->format;
    }

    /**
     * Set the timestamp. If the given timestamp is a string it is passed to
     * strtotime. The timestamp is only assigned if the value is numeric.
     *
     * @param int|string $timestamp The format string, using PHP's date format.
     *
     * @access public
     * @return \Llama\Timestamp
     */
    public function setTimestamp($timestamp)
    {
        if (!is_int($timestamp)) {
            $timestamp = strtotime($timestamp);

            if ($timestamp == '' || !is_int($timestamp)) {
                return;
            }
        }

        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Return the timestamp if set, otherwise return the current timestamp.
     *
     * @access public
     * @return int
     */
    public function getTimestamp()
    {
        return is_null($this->timestamp) ? time() : $this->timestamp;
    }

    // -- Magic Methods

    /**
     * Return the string using the specified format.
     *
     * @access public
     * @return string
     */
    public function __toString()
    {
        return date($this->getFormat(), $this->getTimestamp());
    }
}

