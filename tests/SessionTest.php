<?php
use Llama\Session;

class SessionTest extends PHPUnit_Framework_TestCase
{
    protected $session;

    public function __construct()
    {
        $this->session = new \Llama\Session('test', 'test-id');
        $this->session->set('test_set_name', 'test_set_value');
    }

    /**
     * Test the __constructor of the Session class:
     *  - ensure the session_name is set correctly
     *  - ensure the session_id is set correctly
     */
    public function testSession()
    {
        $this->assertEquals('test', session_name(), session_name() . " is not equal to 'test'");
        $this->assertEquals('test-id', session_id(), session_id() . " is not equal to 'test-id'");
    }

    /**
     * Test the set of the Session class:
     *  - ensure the value is set in the data array
     */
    public function testSet()
    {
        $this->assertAttributeEquals(array('test_set_name' => 'test_set_value'), 'data', $this->session);
    }

    /**
     * Test the get of the Session class:
     *  - ensure the correct value is returned
     */
    public function testGet()
    {
        $this->assertEquals('test_set_value', $this->session->get('test_set_name'));
    }

    /**
     * Test the getOnce of the Session class:
     *  - ensure the correct value is returned
     *  - ensure the value has been removed from the data array
     */
    public function testGetOnce()
    {
        $this->assertEquals('test_set_value', $this->session->getOnce('test_set_name'));
        $this->assertAttributeEquals(array(), 'data', $this->session);
    }

    /**
     * Test the destroy method of the Session class:
     *  - ensure the data array is emptied
     */
    public function testDestroy()
    {
        $this->session->destroy();
    }
}

