<?php
use Llama\ErrorHandler;
use Llama\Exception;
use Llama\Logger;

/**
 * ErrorHandler test case.
 */
class ErrorHandlerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var \Closure
     */
    private $onFatalCallback;

    /**
     * @var ErrorHandler
     */
    private $errorHandler;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->logger = Logger::configure(realpath(TESTS_PATH . '/_resources/error_handler_logger.ini'));

        $this->onFatalCallback = function () {
            throw new \Llama\Exception('this is a test');
        };

        $this->errorHandler = new ErrorHandler($this->logger, $this->onFatalCallback);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->errorHandler = null;

        parent::tearDown();
    }

    /**
     * Tests ErrorHandler->__construct()
     */
    public function testMagicConstruct()
    {
        $this->assertAttributeEquals($this->logger, 'logger', $this->errorHandler);
        $this->assertAttributeEquals($this->onFatalCallback, 'onFatalCallback', $this->errorHandler);
    }

    /**
     * Tests ErrorHandler->capture()
     *
     * @expectedException        \Llama\Exception
     * @expectedExceptionMessage this is a test
     */
    public function testCaptureFatalError()
    {
        trigger_error('Test error', E_USER_ERROR);
    }

    /**
     * Tests ErrorHandler->getCodeExtract()
     */
    public function testGetCodeExtract()
    {
        $lineNumber = (__LINE__ + 6); $test = '
Pork belly prosciutto ball tip rump shoulder bresaola. Shankle
turducken tri-tip boudin, jerky venison ground round tenderloin
frankfurter ribeye chicken. Bacon boudin pork belly, ribeye
tri-tip swine hamburger. Pancetta fatback ball tip, chicken pork
belly corned beef andouille jerky short loin. Shoulder pork chop
tail, tri-tip beef ribs short loin t-bone biltong andouille
bresaola turducken sirloin. Boudin prosciutto shoulder, flank
ribeye ham hock pork loin spare ribs. Beef ribs short loin pastrami
cow, brisket andouille shoulder flank swine. Ground round meatball
shoulder short loin tenderloin pig turkey flank tongue shankle tri-tip,
prosciutto ham hock rump speck.
';

        $lines = explode("\n", trim($test));
        $start = $lineNumber - 5;
        $end = $lineNumber + 6;

        for ($i = $start; $i < $end; $i++) {
            $key = key($lines);

            $lines[$key] = $i . ': ' . current($lines);

            if ($i == $lineNumber) {
                $lines[$key] = '<span style="color: #C00; font-weight: bold;">' . current($lines) . '</span>';
            }

            next($lines);
        }

        $this->assertEquals(implode(PHP_EOL, $lines), $this->errorHandler->getCodeExtract(__FILE__, $lineNumber));
    }

    /**
     * Tests ErrorHandler->getCodeExtract()
     *
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage Error file does not exist.
     */
    public function testGetCodeExtractFileNotFoundException()
    {
        $this->errorHandler->getCodeExtract('idontexist.php', 0);
    }

    /**
     * Tests ErrorHandler->__destruct()
     */
    public function testMagicDestruct()
    {
        $this->markTestIncomplete('Not yet implemented');
    }
}

