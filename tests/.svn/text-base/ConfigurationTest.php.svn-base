<?php
use Llama\Configuration;

class ConfigurationTest extends PHPUnit_Framework_TestCase
{
    private $configuration;

    private $testDataOneDimensional = array(
        'test_key_1' => 'test_value_1',
        'test_key_2' => 'test_value_2',
        'test_key_3' => 'test_value_3'
    );

    private $testDataMultiDimensional = array(
        'test_key_1' => 'test_value_1',
        'test_key_2' => 'test_value_2',
        'test_key_3' => array(
            'test_sub_key_1' => 'test_sub_value_1',
            'test_sub_key_2' => 'test_sub_value_2',
            'test_sub_key_3' => 'test_sub_value_3'
        )
    );

    protected function setUp()
    {
        $this->configuration = new Configuration($this->testDataOneDimensional);

        parent::setUp();
    }

    protected function tearDown()
    {
        $this->configuration = null;

        parent::tearDown();
    }

    /**
     * Test the count method of the Configuration class:
     *  - ensure the size of the object is zero
     */
    public function testCount()
    {
        $this->assertTrue($this->configuration->count() == sizeof($this->testDataOneDimensional));
    }

    /**
     * Test the Constructor of the Configuration class:
     *  - ensure a one-dimensional array is added successfully
     *  - ensure a multi-dimensional array is added successfully
     *
     *  @depends testCount
     */
    public function testConfiguration()
    {
        $this->assertTrue($this->configuration->count() == sizeof($this->testDataOneDimensional));

        $this->configuration = new Configuration($this->testDataMultiDimensional);

        $count1 = $this->configuration->test_key_3->count();
        $count2 = sizeof($this->testDataMultiDimensional['test_key_3']);

        $this->assertTrue($count1 == $count2);
    }

    /**
     * Test the current method of the Configuration class:
     *  - ensure the internal pointer is pointing to the first value of the array
     */
    public function testCurrent()
    {
        $this->assertTrue($this->configuration->current() == $this->configuration->test_key_1);
    }

    /**
     * Test the next method of the Configuration class:
     *  - ensure the internal pointer is pointing to the second value of the array
     *  - ensure the internal pointer is not altered after unsetting a value while in a loop
     *
     *  @depends testCurrent
     */
    public function testNext()
    {
        $this->configuration->next();

        $this->assertTrue($this->configuration->current() == $this->configuration->test_key_2);

        foreach ($this->configuration as $key => $value) {
            unset($this->configuration->$key);

            break;
        }

        $this->configuration->next();

        $this->assertTrue($this->configuration->current() == $this->configuration->test_key_2);
    }

    /**
     * Test the rewind method of the Configuration class:
     *  - ensure the internal pointer is pointing to the first value of the array
     *
     *  @depends testCurrent
     */
    public function testRewind()
    {
        $this->configuration->next();
        $this->configuration->rewind();

        $this->assertTrue($this->configuration->current() == $this->configuration->test_key_1);
    }

    /**
     * Test the key method of the Configuration class:
     *  - ensure the key is the first key of the array
     */
    public function testKey()
    {
        $this->assertTrue($this->configuration->key() == 'test_key_1');
    }

    /**
     * Test the valid method of the Configuration class:
     *  - ensure that true is returned for a valid position
     *  - ensure that false is returned for an invalid position
     */
    public function testValid()
    {
        $this->configuration->next();

        $this->assertTrue($this->configuration->valid());

        $this->configuration = new Configuration(array());
        $this->configuration->next();

        $this->assertFalse($this->configuration->valid());
    }

    /**
     * Test the get method of the Configuration class:
     *  - ensure the value of an existing key is returned
     *  - ensure null is returned for a non-existent key
     *  - ensure the specified default value is returned for a non-existent key
     */
    public function testGet()
    {
        $value1 = $this->configuration->get('test_key_3');
        $value2 = $this->configuration->get('i_am_not_a_key');
        $value3 = $this->configuration->get('i_am_not_a_key', 'i am the default value');

        $this->assertTrue($value1 == 'test_value_3');
        $this->assertNull($value2);
        $this->assertTrue($value3 == 'i am the default value');
    }

    /**
     * Test the __get method of the Configuration class:
     *  - ensure the value of an existing key is returned
     *  - ensure null is returned for a non-existent key
     */
    public function testMagicGet()
    {
        $this->assertTrue($this->configuration->test_key_3 == 'test_value_3');
        $this->assertNull($this->configuration->i_am_not_a_key);
    }

    /**
     * Test the __isset method of the Configuration class:
     *  - ensure true is returned for an existing key
     *  - ensure false is returned for a non-existent key
     */
    public function testMagicIsset()
    {
        $this->assertTrue(isset($this->configuration->test_key_3));
        $this->assertFalse(isset($this->configuration->i_dont_exist));
    }

    /**
     * Test the __unset method of the Configuration class:
     *  - ensure the value is unset
     */
    public function testMagicUnset()
    {
        $this->assertTrue($this->configuration->count() == 3);

        unset($this->configuration->test_key_2);

        $this->assertTrue($this->configuration->count() == 2);
    }
}

