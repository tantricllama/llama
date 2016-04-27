<?php
namespace Llama\Logger\Appender;

use Llama\Logger\AppenderInterface;
use Llama\Logger\EventInterface;

/**
 * Email Appender for use in the Logger class.
 *
 * @category   Llama
 * @package    Logger
 * @subpackage Appender
 * @author     Brendan Smith <brendan.s@crazydomains.com>
 * @version    1.0
 *
 * @uses       \Llama\Logger\AppenderInterface
 * @uses       \Llama\Logger\EventInterface
 */
class Email implements AppenderInterface
{

    /**
     * Receiver(s) of the email. The formatting of this string must comply
     * with » RFC 2822. Some examples are:
     *     user@example.com
     *     user@example.com, anotheruser@example.com
     *     User <user@example.com>
     *     User <user@example.com>, Another User <anotheruser@example.com>
     *
     * @access private
     * @var    string
     */
    private $to;

    /**
     * Sender of the email. The formatting of this string must comply with » RFC
     * 2822. Some examples are:
     *     user@example.com
     *     User <user@example.com>
     *
     * @access private
     * @var    string
     */
    private $from;

    /**
     * The subject of the email.
     *
     * @access private
     * @var    string
     */
    private $subject;

    /**
     * The body of the email.
     *
     * @access private
     * @var    string
     */
    private $body;

    /**
     * The layout type of the email.
     *
     * @access private
     * @var    string
     */
    private $layout = 'horizontal';

    /**
     * Indicates whether the appender should automatically log events as they are
     * appended.
     *
     * @access private
     * @var    bool
     */
    private $autoLog = false;

    /**
     * Indicates whether the appender should run in dry mode (for testing).
     *
     * @access private
     * @var    bool
     */
    private $dry = false;

    /**
     * Constructor
     *
     * Configures the appender.
     *
     * @param array $config The appenders configuration.
     *
     * @access public
     */
    public function __construct(array $config)
    {
        $this->to = $config['to'];
        $this->from = $config['from'];
        $this->subject = $config['subject'];

        if (isset($config['layout'])) {
            $this->setLayout($config['layout']);
        }

        if (isset($config['autoLog'])) {
            $this->autoLog = (bool) $config['autoLog'];
        }

        if (isset($config['dry'])) {
            $this->dry = (bool) $config['dry'];
        }
    }

    /**
     * Set the layout.
     *
     * @param bool $layout Accepted values are 'horizontal' or 'vertical'.
     *
     * @access public
     * @return void
     */
    public function setLayout($layout)
    {
        $this->layout = ($layout == 'horizontal' ? 'horizontal' : 'vertical');
    }

    /**
     * Enable/Disable auto-log mode.
     *
     * @param bool $autoLog If true, the appender will be set to auto-log mode.
     *
     * @access public
     * @return void
     */
    public function setAutoLog($autoLog)
    {
        $this->autoLog = $autoLog;
    }

    /**
     * Enable/Disable dry mode.
     *
     * @param bool $dry If true, the appender will be set to dry mode.
     *
     * @access public
     * @return void
     */
    public function setDry($dry)
    {
        $this->dry = $dry;
    }

    /**
     * Append the log event details to the email body.
     *
     * @param EventInterface $event The log event.
     *
     * @access public
     * @return void
     */
    public function append(EventInterface $event)
    {
        if ($this->layout == 'horizontal') {
            $this->body .= <<<EVT
<tr>
    <td>{$event->getTimestamp()}</td>
    <td>{$event->getLevel()}</td>
    <td>{$event->getCode()}</td>
    <td>{$event->getMessage()}</td>
    <td>{$event->getFile()}</td>
    <td>{$event->getLine()}</td>
</tr>
EVT;
        } else {
            $this->body .= <<<EVT
<tr>
    <td>Timestamp:</td>
    <td>{$event->getTimestamp()}</td>
</tr>
<tr>
    <td>Level:</td>
    <td>{$event->getLevel()}</td>
</tr>
<tr>
    <td>File:</td>
    <td>{$event->getFile()}</td>
</tr>
<tr>
    <td>Line:</td>
    <td>{$event->getLine()}</td>
</tr>
<tr>
    <td>Code:</td>
    <td>{$event->getCode()}</td>
</tr>
<tr>
    <td colspan="2">Message:</td>
</tr>
<tr>
    <td colspan="2">&nbsp;</td>
</tr>
<tr>
    <td colspan="2">{$event->getMessage()}</td>
</tr>
EVT;
        }

        if ($this->autoLog) {
            $this->log();

            $this->body = '';
        }
    }

    /**
     * Send the email.
     *
     * @access public
     * @return void
     */
    public function log()
    {
        if ($this->body == '') {
            return;
        }

        $message = $this->getHeader()
                 . $this->body
                 . $this->getFooter();

        $headers = "From: $this->from\n"
                 . "MIME-Version: 1.0\n"
                 . "Content-Type: text/html;\n";

        if ($this->dry) {
            echo "Logger\\Email Dry Mode Output: {$this->body}";
        } else {
            mail($this->to, $this->subject, $message, $headers);
        }
    }

    /**
     * Return the email header.
     *
     * @access private
     * @return string
     */
    private function getHeader()
    {
        $return = <<<HED
<!DOCTYPE html>
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>$this->subject</title>
</head>
<body>
    <table>
HED;

        if ($this->layout == 'horizontal') {
            $return .= '
        <tr>
            <th>Timestamp</th>
            <th>Level</th>
            <th>Code</th>
            <th>Message</th>
            <th>File</th>
            <th>Line</th>
        </tr>';
        }

         return $return;
    }

    /**
     * Return the email footer.
     *
     * @access private
     * @return string
     */
    private function getFooter()
    {
        return "</table>"
             . "</body>"
             . "</html>";
    }
}

