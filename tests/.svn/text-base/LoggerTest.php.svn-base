<?php
use Llama\Logger;

/**
 * Logger test case.
 */
class LoggerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Logger
     */
    private $logger;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->logger = Logger::configure(realpath(TESTS_PATH . '/_resources/logger_test.ini'));
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->logger = null;

        parent::tearDown();
    }

    /**
     * Tests Logger Levels
     *
     * @covers Logger->trace()
     * @covers Logger->debug()
     * @covers Logger->info()
     * @covers Logger->warning()
     * @covers Logger->error()
     * @covers Logger->fatal()
     * @covers Logger->__destruct()
     */
    public function testLevels()
    {
        $this->logger->trace('trace_test', 1000);
        $this->logger->debug('debug_test', 2000);
        $this->logger->info('info_test', 3000);
        $this->logger->warning('warning_test', 4000);
        $this->logger->error('error_test', 5000);
        $this->logger->fatal('fatal_test', 6000);

        ob_start();

        $this->logger->__destruct();

        $output = ob_get_clean();

        $this->assertContains('Trace', $output);
        $this->assertContains('1000', $output);
        $this->assertContains('trace_test', $output);

        $this->assertContains('Debug', $output);
        $this->assertContains('2000', $output);
        $this->assertContains('debug_test', $output);

        $this->assertContains('Info', $output);
        $this->assertContains('3000', $output);
        $this->assertContains('info_test', $output);

        $this->assertContains('Warning', $output);
        $this->assertContains('4000', $output);
        $this->assertContains('warning_test', $output);

        $this->assertContains('Error', $output);
        $this->assertContains('5000', $output);
        $this->assertContains('error_test', $output);

        $this->assertContains('Fatal', $output);
        $this->assertContains('6000', $output);
        $this->assertContains('fatal_test', $output);
    }

    /**
     * Tests Logger::getLogger()
     */
    public function testGetLogger()
    {
        $logger = Logger::getLogger('TEST_LOGGER');

        $this->assertAttributeContains('TEST_LOGGER', 'name', $logger);
    }

    /**
     * Tests Logger::getLogger() "Logger not found" exception
     *
     * @expectedException RuntimeException
     */
    public function testGetLoggerException()
    {
        Logger::getLogger('NO_LOGGER');
    }

    /**
     * Tests Logger::configure() "File not found" exception
     *
     * @expectedException InvalidArgumentException
     */
    public function testConfigureFileNotFound()
    {
        Logger::configure('not_found.ini');
    }

    /**
     * Tests Logger::configure() "Appender not found" exception
     *
     * @expectedException InvalidArgumentException
     */
    public function testConfigureAppenderNotFound()
    {
        Logger::configure(realpath(TESTS_PATH . '/_resources/logger_no_appender_test.ini'));
    }
}

