<?php
use Llama\Logger\Appender\Email;

/**
 * Email test case.
 */
class EmailTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Email
     */
    private $email;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->email = new Email(
            array(
                'to' => 'receiver@example.com',
                'from' => 'sender@example.com',
                'subject' => 'Testing'
            )
        );
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->email = null;

        parent::tearDown();
    }

    /**
     * Tests Email->__construct() has assigned the class properties.
     */
    public function testMagicConstruct()
    {
        $this->assertAttributeEquals('receiver@example.com', 'to', $this->email);
        $this->assertAttributeEquals('sender@example.com', 'from', $this->email);
        $this->assertAttributeEquals('Testing', 'subject', $this->email);
    }

    /**
     * Tests Email->setLayout()
     */
    public function testSetLayout()
    {
        $this->email->setLayout('vertical');
        $this->assertAttributeEquals('vertical', 'layout', $this->email);
        $this->email->setLayout('horizontal');
        $this->assertAttributeEquals('horizontal', 'layout', $this->email);
    }

    /**
     * Tests Email->setAutoLog()
     */
    public function testSetAutoLog()
    {
        $this->email->setAutoLog(true);
        $this->assertAttributeEquals(true, 'autoLog', $this->email);
        $this->email->setAutoLog(false);
        $this->assertAttributeEquals(false, 'autoLog', $this->email);
    }

    /**
     * Tests Email->setDry()
     */
    public function testSetDry()
    {
        $this->email->setDry(true);
        $this->assertAttributeEquals(true, 'dry', $this->email);
        $this->email->setDry(false);
        $this->assertAttributeEquals(false, 'dry', $this->email);
    }

    /**
     * Tests Email->append()
     */
    public function testAppend()
    {
        $this->email->append($this->getMockEvent());

        $this->assertAttributeContains('test_timestamp', 'body', $this->email);
        $this->assertAttributeContains('test_level', 'body', $this->email);
        $this->assertAttributeContains('test_code', 'body', $this->email);
        $this->assertAttributeContains('test_message', 'body', $this->email);
        $this->assertAttributeContains('test_file', 'body', $this->email);
        $this->assertAttributeContains('test_line', 'body', $this->email);
    }

    /**
     * Tests Email->log()
     */
    public function testLog()
    {
        ob_start();

        $this->email->setDry(true);
        $this->email->append($this->getMockEvent());
        $this->email->log();

        $log = ob_get_contents();

        $this->assertContains('test_timestamp', $log);
        $this->assertContains('test_level', $log);
        $this->assertContains('test_code', $log);
        $this->assertContains('test_message', $log);
        $this->assertContains('test_file', $log);
        $this->assertContains('test_line', $log);
    }

    /**
     * Tests Email->log() is fire automatically when a log entry is appended and
     * auto-log has been enabled.
     */
    public function testAutoLog()
    {
        ob_start();

        $this->email->setDry(true);
        $this->email->setAutoLog(true);
        $this->email->append($this->getMockEvent());

        $log = ob_get_contents();

        $this->assertAttributeEquals('', 'body', $this->email);
        $this->assertContains('test_timestamp', $log);
        $this->assertContains('test_level', $log);
        $this->assertContains('test_code', $log);
        $this->assertContains('test_message', $log);
        $this->assertContains('test_file', $log);
        $this->assertContains('test_line', $log);
    }

    /**
     * Tests Email->append() with vertical layout.
     */
    public function testAutoLogVerticalLayout()
    {
        ob_start();

        $this->email->setDry(true);
        $this->email->setAutoLog(true);
        $this->email->setLayout('vertical');
        $this->email->append($this->getMockEvent());

        $log = ob_get_contents();

        $this->assertContains('Timestamp:', $log);
        $this->assertContains('test_timestamp', $log);
        $this->assertContains('Level:', $log);
        $this->assertContains('test_level', $log);
        $this->assertContains('Code:', $log);
        $this->assertContains('test_code', $log);
        $this->assertContains('Message:', $log);
        $this->assertContains('test_message', $log);
        $this->assertContains('File:', $log);
        $this->assertContains('test_file', $log);
        $this->assertContains('Line:', $log);
        $this->assertContains('test_line', $log);
    }

    private function getMockEvent()
    {
        $event = $this->getMock(
            'Llama\Logger\Event',
            array(
                'getTimestamp',
                'getLevel',
                'getCode',
                'getMessage',
                'getFile',
                'getLine'
            ),
            array(),
            '',
            false
        );

        $event->expects($this->once())
              ->method('getTimestamp')
              ->will($this->returnValue('test_timestamp'));

        $event->expects($this->once())
              ->method('getLevel')
              ->will($this->returnValue('test_level'));

        $event->expects($this->once())
              ->method('getCode')
              ->will($this->returnValue('test_code'));

        $event->expects($this->once())
              ->method('getMessage')
              ->will($this->returnValue('test_message'));

        $event->expects($this->once())
              ->method('getFile')
              ->will($this->returnValue('test_file'));

        $event->expects($this->once())
              ->method('getLine')
              ->will($this->returnValue('test_line'));

        return $event;
    }
}

