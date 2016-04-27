<?php
namespace Llama;

use Llama\LoggerInterface;

/**
 * An error handling class which can be used to override PHP's internal error
 * handler. Example usage:
 *
 * $logger = Logger::getLogger('ERROR_LOGGER');
 * $onFatalCallback = function () {
 *     exit();
 * };
 * $errorHandler = new ErrorHandler($logger, $onFatalCallback, E_WARNING);
 * $erroneous = 1 / 0; //division by zero warning
 *
 * @category Llama
 * @package  ErrorHandler
 * @author   Brendan Smith <brendan.s@crazydomains.com>
 * @version  1.0
 */
class ErrorHandler
{

    /**
     * Stores the details of the error for use in the logging methods.
     *
     * @access private
     * @var    array
     */
    private $errorData;

    /**
     * An array mapping PHP's error constants to text labels.
     *
     * @access private
     * @var    array
     */
    private $errorTypes = array(
        E_STRICT  => array(
            'class' => 'notice',
            'label' => 'E_STRICT',
            'anchor' => 'errorfunc.constants.errorlevels.e-strict'
        ),
        E_NOTICE  => array(
            'class' => 'notice',
            'label' => 'E_NOTICE',
            'anchor' => 'errorfunc.constants.errorlevels.e-notice'
        ),
        E_USER_NOTICE => array(
            'class' => 'notice',
            'label' => 'E_USER_NOTICE',
            'anchor' => 'errorfunc.constants.errorlevels.e-user-notice'
        ),
        E_DEPRECATED => array(
            'class' => 'warning',
            'label' => 'E_DEPRECATED',
            'anchor' => 'errorfunc.constants.errorlevels.e-deprecated-error'
        ),
        E_USER_DEPRECATED => array(
            'class' => 'warning',
            'label' => 'E_USER_DEPRECATED',
            'anchor' => 'errorfunc.constants.errorlevels.e-user-deprecated'
        ),
        E_USER_WARNING => array(
            'class' => 'warning',
            'label' => 'E_USER_WARNING',
            'anchor' => 'errorfunc.constants.errorlevels.e-user-warning'
        ),
        E_WARNING  => array(
            'class' => 'warning',
            'label' => 'E_WARNING',
            'anchor' => 'errorfunc.constants.errorlevels.e-warning'
        ),
        E_RECOVERABLE_ERROR => array(
            'class' => 'error',
            'label' => 'E_RECOVERABLE_ERROR',
            'anchor' => 'errorfunc.constants.errorlevels.e-recoverable-error'
        ),
        E_USER_ERROR => array(
            'class' => 'error',
            'label' => 'E_USER_ERROR',
            'anchor' => 'errorfunc.constants.errorlevels.e-user-error'
        )
    );

    /**
     * Logger used to log errors when they are caught.
     *
     * @access private
     * @var    LoggerInterface
     */
    private $logger;

    /**
     * An array containing the data used by the chosen logging type.
     *
     * @access private
     * @var    array
     */
    private $logData;

    /**
     * A callback used when a fatal error is caught.
     *
     * @access private
     * @var    \Closure
     */
    private $onFatalCallback;

    /**
     * Constructor
     *
     * Stores the current error handler internally before overriding it. The
     * previous error handler will be restored when the object is destroyed.
     *
     * @param LoggerInterface $logger          Logger used for logging errors.
     * @param \Closure        $onFatalCallback Closure to call if a fatal error is caught.
     * @param int             $errorTypes      Error reporting level.
     *
     * @access public
     */
    public function __construct(LoggerInterface $logger, \Closure $onFatalCallback, $errorTypes = E_ALL)
    {
        error_reporting($errorTypes);
        ini_set('display_errors', 'Off');

        $this->reset();
        $this->logger = $logger;
        $this->onFatalCallback = $onFatalCallback;

        set_error_handler(array($this, 'capture'), $errorTypes);
    }

    /**
     * Captures the errors, extracts and stores details about the error.
     *
     * @param int    $errorNumber  The level of the error raised.
     * @param string $errorString  The error message.
     * @param string $errorFile    The file which contains the offending code.
     * @param int    $errorLine    The line on which the error occurred.
     * @param array  $errorContext An array of every variable that existed in the
     *                             scope the error was triggered in.
     *
     * @access public
     * @return boolean
     */
    public function capture($errorNumber, $errorString, $errorFile, $errorLine, array $errorContext)
    {
        $this->errorData = array(
            'number' => $errorNumber,
            'string' => $errorString,
            'file' => $errorFile,
            'line' => $errorLine,
            'label' => $this->errorTypes[$errorNumber]['label'],
            'class' => $this->errorTypes[$errorNumber]['class'],
            'anchor' => $this->errorTypes[$errorNumber]['anchor'],
            'globals' => print_r($GLOBALS, true),
            'context' => print_r($errorContext, true),
            'extract' => $this->getCodeExtract($errorFile, $errorLine)
        );

        // This is a fix for the memory leak we get when running our unit tests
        $backtrace = debug_backtrace();
        $sanitizedBacktrace = array();

        foreach ($backtrace as $back) {
            if (stripos($back['class'], 'PHPUnit') !== false) {
                unset($back['args'], $back['object']);
            }

            $sanitizedBacktrace[] = $back;
        }

        $this->errorData['trace'] = print_r($sanitizedBacktrace, true);

        $this->log();
        $this->reset();

        switch ($errorNumber) {
            case E_STRICT:
            case E_NOTICE:
            case E_USER_NOTICE:
            case E_DEPRECATED:
            case E_USER_DEPRECATED:
            case E_USER_WARNING:
            case E_WARNING:
                return true;
            case E_RECOVERABLE_ERROR:
            case E_USER_ERROR:
                $onFatalCallback = $this->onFatalCallback;
                $onFatalCallback();
        }
    }

    /**
     * Return a chunk of the code encapsulating the offending line.
     *
     * @param string $errorFile The file which contains the offending code.
     * @param int    $errorLine The line on which the error occurred.
     *
     * @access public
     * @throws \InvalidArgumentException
     * @return string
     */
    public function getCodeExtract($errorFile, $errorLine)
    {
        if (!file_exists($errorFile)) {
            throw new \InvalidArgumentException('Error file does not exist.');
        }

        if (!is_readable($errorFile)) {
            throw new \InvalidArgumentException('Error file is not readable.');
        }

        $lines = file($errorFile);
        $lineCount = sizeof($lines);
        $startLine = $errorLine - 5;

        //prepend the lines array with an empty value so the keys match the line
        //numbers correctly.
        array_unshift($lines, null);

        if ($startLine < 1 || $lineCount < 11) {
            $startLine = 1;
        }

        $extractedLines = array_slice($lines, $startLine, 11, true);
        $keyPadSize = strlen(max(array_keys($extractedLines))) + 2;

        foreach ($extractedLines as $lineNumber => $lineText) {
            $lineText = str_replace(
                array("\t", "\r", "\n"),
                array('    ', ' ', ' '),
                $lineText
            );

            $lineText = str_pad($lineNumber . ':', $keyPadSize, ' ', STR_PAD_RIGHT) . rtrim($lineText);
            $lineText = htmlentities($lineText);

            if ($lineNumber == $errorLine) {
                $lineText = '<span style="color: #C00; font-weight: bold;">' . $lineText . '</span>';
            }

            $extractedLines[$lineNumber] = $lineText;
        }

        return implode(PHP_EOL, $extractedLines);
    }

    /**
     * Destructor
     *
     * Restores the previous error handler.
     *
     * @access public
     */
    public function __destruct()
    {
        restore_error_handler();
    }

    /**
     * Reset the $errorData array.
     *
     * @access public
     */
    private function reset()
    {
        $this->errorData = array(
            'number' => null,
            'string' => null,
            'file' => null,
            'line' => null,
            'label' => null,
            'class' => null,
            'anchor' => null,
            'context' => null,
            'extract' => null,
            'trace' => null
        );
    }

    /**
     * Log the errors using the specified log type.
     *
     * @access private
     * @return void
     */
    private function log()
    {
        if (is_null($this->errorData['number'])) {
            return;
        }

        $manualUrl = "http://www.php.net/manual/en/errorfunc.constants.php#{$this->errorData['anchor']}";

        if ($this->errorData['class'] == 'notice') {
            $backgroundColour = '#eee';
        } elseif ($this->errorData['class'] == 'warning') {
            $backgroundColour = '#ff7';
        } elseif ($this->errorData['class'] == 'error') {
            $backgroundColour = '#fdd';
        }

        $message = <<<MSG
<div style="color: #362211; font-family: adelle-1, adelle-2; font-size: 14px; line-height: 1.4em;">
    <h3><a name="top">Summary</a></h3>
    <table style="border: 1px solid #999;">
        <tr>
            <td style="padding: 5px; background-color: $backgroundColour; font-weight: bold;">Error:</td>
            <td style="padding: 5px; background-color: $backgroundColour;">
                <a href="$manualUrl" target="_blank">{$this->errorData['label']}</a>:
                {$this->errorData['string']}
            </td>
        </tr>
        <tr>
            <td style="padding: 5px; background-color: $backgroundColour; font-weight: bold;">File:</td>
            <td style="padding: 5px; background-color: $backgroundColour;">{$this->errorData['file']}</td>
        </tr>
        <tr>
            <td style="padding: 5px; background-color: $backgroundColour; font-weight: bold;">Line:</td>
            <td style="padding: 5px; background-color: $backgroundColour;">{$this->errorData['line']}</td>
        </tr>
        <tr>
            <td style="padding: 5px; background-color: $backgroundColour; font-weight: bold;">Extract:</td>
            <td style="padding: 5px; background-color: $backgroundColour;"><a href="#extract">View</a></td>
        </tr>
        <tr>
            <td style="padding: 5px; background-color: $backgroundColour; font-weight: bold;">Trace:</td>
            <td style="padding: 5px; background-color: $backgroundColour;"><a href="#trace">View</a></td>
        </tr>
        <tr>
            <td style="padding: 5px; background-color: $backgroundColour; font-weight: bold;">Context:</td>
            <td style="padding: 5px; background-color: $backgroundColour;"><a href="#context">View</a></td>
        </tr>
        <tr>
            <td style="padding: 5px; background-color: $backgroundColour; font-weight: bold;">Globals:</td>
            <td style="padding: 5px; background-color: $backgroundColour;"><a href="#globals">View</a></td>
        </tr>
    </table>
    <br />
    <h3><a name="extract">Extract</a></h3>
    <table style="border: 1px solid #999; vertical-align: top;">
        <tr>
            <td style="padding: 5px; background-color: $backgroundColour;">
                <pre style="margin: 0px;">{$this->errorData['extract']}</pre>
            </td>
        </tr>
    </table>
    <p><a href="#top">Top</a></p>
    <br />
    <h3><a name="trace">Trace</a></h3>
    <table style="border: 1px solid #999; vertical-align: top;">
        <tr>
            <td style="padding: 5px; background-color: $backgroundColour;">
                <pre style="margin: 0px;">{$this->errorData['trace']}</pre>
            </td>
        </tr>
    </table>
    <p><a href="#top">Top</a></p>
    <br />
    <h3><a name="context">Context</a></h3>
    <table style="border: 1px solid #999; vertical-align: top;"k>
        <tr>
            <td style="padding: 5px; background-color: $backgroundColour;">
                <pre style="margin: 0px;">{$this->errorData['context']}</pre>
            </td>
        </tr>
    </table>
    <p><a href="#top">Top</a></p>
    <br />
    <h3><a name="globals">Globals</a></h3>
    <table style="border: 1px solid #999; vertical-align: top;"k>
        <tr>
            <td style="padding: 5px; background-color: $backgroundColour;">
                <pre style="margin: 0px;">{$this->errorData['globals']}</pre>
            </td>
        </tr>
    </table>
    <p><a href="#top">Top</a></p>
</div>
MSG;

        if ($this->errorData['class'] == 'notice') {
            $this->logger->info($message);
        } elseif ($this->errorData['class'] == 'warning') {
            $this->logger->warning($message);
        } elseif ($this->errorData['class'] == 'error') {
            $this->logger->error($message);
        }
    }
}

