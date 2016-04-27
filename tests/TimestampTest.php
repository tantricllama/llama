<?php
use Llama\Timestamp;

/**
 * Timestamp test case.
 */
class TimestampTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Timestamp
     */
    private $timestampObj;

    /**
     * @var int
     */
    private $timestamp;

    /**
     * @var string
     */
    private $format;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->timestamp = time();
        $this->format = 'j M y';
        $this->timestampObj = new Timestamp($this->timestamp);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->timestampObj = null;
        $this->timestamp = null;
        $this->format = null;

        parent::tearDown();
    }

    /**
     * Tests Timestamp->__construct()
     */
    public function testMagicConstruct()
    {
        $this->assertAttributeEquals($this->timestamp, 'timestamp', $this->timestampObj);
    }

    /**
     * Tests Timestamp->setFormat()
     */
    public function testSetFormat()
    {
        $this->assertInstanceOf('Llama\\Timestamp', $this->timestampObj->setFormat('d m Y'));
        $this->assertAttributeEquals('d m Y', 'format', $this->timestampObj);
    }

    /**
     * Tests Timestamp->getFormat()
     */
    public function testGetFormat()
    {
        $this->assertEquals($this->format, $this->timestampObj->getFormat());
    }

    /**
     * Tests Timestamp->setTimestamp()
     */
    public function testSetTimestamp()
    {
        $this->assertInstanceOf('Llama\\Timestamp', $this->timestampObj->setTimestamp($this->timestamp - 100));
        $this->assertAttributeEquals(($this->timestamp - 100), 'timestamp', $this->timestampObj);

        $this->timestampObj->setTimestamp('not a valid timestamp');
        $this->assertAttributeEquals(($this->timestamp - 100), 'timestamp', $this->timestampObj);

        $this->timestampObj->setTimestamp('now');
        $this->assertAttributeEquals(time(), 'timestamp', $this->timestampObj);
    }

    /**
     * Tests Timestamp->getTimestamp()
     */
    public function testGetTimestamp()
    {
        $this->assertEquals($this->timestamp, $this->timestampObj->getTimestamp());
    }

    /**
     * Tests Timestamp->__toString()
     */
    public function testMagicToString()
    {
        $this->assertEquals(date($this->format, $this->timestamp), $this->timestampObj);
    }
}

