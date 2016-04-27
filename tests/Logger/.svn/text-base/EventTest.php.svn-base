<?php
use Llama\Logger\Event;

/**
 * Event test case.
 */
class EventTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Event
     */
    private $event;

    /**
     * @var int
     */
    private $timestamp;

    /**
     * @var int
     */
    private $line;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->timestamp = time();
        $this->getEvent();
        $this->line = __LINE__ - 1; //record the line for testGetLine
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->event = null;

        parent::tearDown();
    }

    /**
     * Tests Event->__construct()
     */
    public function testMagicConstruct()
    {
        $this->assertAttributeEquals(Event::INFO, 'level', $this->event);
        $this->assertAttributeEquals('This is a test', 'message', $this->event);
        $this->assertAttributeEquals(1000, 'code', $this->event);
    }

    /**
     * Tests Event->getLevel()
     */
    public function testGetLevel()
    {
        $this->assertEquals(Event::INFO, $this->event->getLevel());
    }

    /**
     * Tests Event->getMessage()
     */
    public function testGetMessage()
    {
        $this->assertEquals('This is a test', $this->event->getMessage());
    }

    /**
     * Tests Event->getCode()
     */
    public function testGetCode()
    {
        $this->assertEquals(1000, $this->event->getCode());
    }

    /**
     * Tests Event->getFile()
     */
    public function testGetFile()
    {
        $this->assertContains(__FILE__, $this->event->getFile());
    }

    /**
     * Tests Event->getLine()
     */
    public function testGetLine()
    {
        $this->assertEquals($this->line, $this->event->getLine());
    }

    /**
     * Tests Event->getTimestamp()
     */
    public function testGetTimestamp()
    {
        $this->assertEquals($this->timestamp, $this->event->getTimestamp());
    }

    //These two methods are used to ensure that the file/line of the event
    //are for this file.
    private function getEvent()
    {
        $this->event = $this->setUpEvent();
    }

    private function setUpEvent()
    {
        return new Event(Event::INFO, 'This is a test', 1000);
    }
}

