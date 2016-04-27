<?php
use Llama\View\Helper\FormDropdown;

/**
 * FormDropdown test case.
 */
class FormDropdownTest extends PHPUnit_Framework_TestCase
{

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Tests FormDropdown->formDropdown() with an array
     */
    public function testFormDropdownWithArray()
    {
        $formDropdown = new FormDropdown();
        $formDropdownStr = $formDropdown->formDropdown(
            array(
                1 => 'Yes',
                0 => 'No'
            ),
            'test.field',
            1,
            array(
                'style' => 'font-weight: bold;'
            ),
            'Select'
        );

        $searchFor = array(
            '<option value="1" selected="selected">Yes</option>',
            '<option value="0">No</option>',
            'id="test_field"',
            'name="test[field]"',
            'style="font-weight: bold;"',
            '<option value="">Select</option>'
        );

        foreach ($searchFor as $string) {
            $this->assertTrue((stripos($formDropdownStr, $string) !== false));
        }
    }

    /**
     * Tests FormDropdown->formDropdown() with an object
     */
    public function testFormDropdownWithObject()
    {
        $obj1 = new stdClass();
        $obj1->id = 1;
        $obj1->name = 'Yes';

        $obj2 = new stdClass();
        $obj2->id = 0;
        $obj2->name = 'No';

        $objects = new SplObjectStorage();
        $objects->attach($obj1);
        $objects->attach($obj2);

        $formDropdown = new FormDropdown();
        $formDropdownStr = $formDropdown->formDropdown(
            $objects,
            'test.field',
            1,
            array(
                'style' => 'font-weight: bold;'
            ),
            'Select'
        );

        $searchFor = array(
            '<option value="1" selected="selected">Yes</option>',
            '<option value="0">No</option>',
            'id="test_field"',
            'name="test[field]"',
            'style="font-weight: bold;"',
            '<option value="">Select</option>'
        );

        foreach ($searchFor as $string) {
            $this->assertTrue((stripos($formDropdownStr, $string) !== false));
        }
    }

    /**
     * Tests FormDropdown->formDropdown() with no options and an initial label
     */
    public function testFormDropdownWithNoOptionsAndInitialLabel()
    {
        $formDropdown = new FormDropdown();
        $formDropdownStr = $formDropdown->formDropdown(
            null,
            'test.field',
            null,
            array(
                'style' => 'font-weight: bold;'
            ),
            'Select'
        );

        $searchFor = array(
            'id="test_field"',
            'name="test[field]"',
            'style="font-weight: bold;"',
            '<option value="" selected="selected">Select</option>'
        );

        foreach ($searchFor as $string) {
            $this->assertTrue((stripos($formDropdownStr, $string) !== false));
        }
    }
}

