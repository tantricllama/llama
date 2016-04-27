<?php
/**
 * Runs the tests from the /Llama directory
 */

require_once('ConfigurationTest.php');
require_once('Configuration/Reader/INITest.php');
require_once('Controller/RouteTest.php');
require_once('Controller/RouterTest.php');
require_once('ErrorHandlerTest.php');
require_once('ImageTest.php');
require_once('LocaleTest.php');
require_once('LoggerTest.php');
require_once('Logger/EventTest.php');
require_once('Logger/Appender/EmailTest.php');
require_once('SessionTest.php');
require_once('ValidatorTest.php');
require_once('View/Helper/FormDropdownTest.php');
require_once('View/Helper/FormRadioTest.php');

class Llama_AllTests extends PHPUnit_Framework_TestSuite
{

    /**
     * Configures the test suite.
     *
     * @return Llama_AllTests
     */
    public static function suite()
    {
        $suite = new Llama_AllTests('Llama All Tests');
        $suite->addTestSuite('ConfigurationTest');
        $suite->addTestSuite('INITest');
        $suite->addTestSuite('RouteTest');
        $suite->addTestSuite('RouterTest');
        $suite->addTestSuite('ErrorHandlerTest');
        $suite->addTestSuite('ImageTest');
        $suite->addTestSuite('LocaleTest');
        $suite->addTestSuite('LoggerTest');
        $suite->addTestSuite('EventTest');
        $suite->addTestSuite('EmailTest');
        $suite->addTestSuite('SessionTest');
        $suite->addTestSuite('ValidatorTest');
        $suite->addTestSuite('FormDropdownTest');
        $suite->addTestSuite('FormRadioTest');

        return $suite;
    }
}

