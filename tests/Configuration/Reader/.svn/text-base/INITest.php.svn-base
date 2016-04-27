<?php
use Llama\Configuration\Reader\Exception;
use Llama\Configuration\Reader\INI;

class INITest extends PHPUnit_Framework_TestCase
{

    /**
     * Test the Constructor of the INI class with a section passed:
     *  - ensure the bootstrap data is loaded
     *  - ensure the development data is loaded
     *  - ensure the production data is not loaded
     */
    public function testIniWithSection()
    {
        $config = new INI(realpath(TESTS_PATH . '/_resources/ini_test.ini'), 'development');

        $this->assertTrue(isset($config->test->bootstrap));
        $this->assertTrue(isset($config->test->development));
        $this->assertFalse(isset($config->test->production));
    }

    /**
     * Test the Constructor of the INI class with no section passed:
     *  - ensure the bootstrap data is loaded
     *  - ensure the development data is loaded
     *  - ensure the production data is loaded
     */
    public function testIniWithoutSection()
    {
        $config = new INI(realpath(TESTS_PATH . '/_resources/ini_test.ini'));

        $this->assertTrue(isset($config->bootstrap->test->bootstrap));
        $this->assertTrue(isset($config->development->test->development));
        $this->assertTrue(isset($config->production->test->production));
    }

    /**
     * Test the Constructor of the INI class with a file that has no sections:
     *  - ensure the correct data is loaded
     */
    public function testIniNoSections()
    {
        $config = new INI(realpath(TESTS_PATH . '/_resources/ini_test_no_sections.ini'));

        $this->assertTrue(isset($config->test_no_sections_key));
    }

    /**
     * Test the Constructor throws the correct exception when a non-existant file is passed:
     *
     * @expectedException Llama\Configuration\Reader\Exception
     */
    public function testIniNonExistentFileException()
    {
        $config = new INI('non_existent.ini');
    }

    /**
     * Test the Constructor throws the correct exception when a requested section does not exist:
     *
     * @expectedException Llama\Configuration\Reader\Exception
     */
    public function testIniInvalidSectionException()
    {
        $config = new INI(realpath(TESTS_PATH . '/_resources/ini_test.ini'), 'i_dont_exist');
    }

    /**
     * Test the Constructor throws the correct exception when a .ini file section has more than 1 extension:
     *
     * @expectedException Llama\Configuration\Reader\Exception
     */
    public function testIniTooManyExtensionsException()
    {
        $config = new INI(realpath(TESTS_PATH . '/_resources/ini_test_too_many_extensions.ini'), 'development');
    }

    /**
     * Test the Constructor throws the correct exception when a .ini file section has extends a non-existent section:
     *
     * @expectedException Llama\Configuration\Reader\Exception
     */
    public function testIniNonExistentExtensionException()
    {
        $config = new INI(realpath(TESTS_PATH . '/_resources/ini_test_non_existent_extensions.ini'), 'development');
    }
}

