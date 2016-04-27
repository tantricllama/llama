<?php
use Llama\View\Helper\FormRadio;

/**
 * FormRadio test case.
 */
class FormRadioTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var FormRadio
     */
    protected $formRadio;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->formRadio = new FormRadio();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->formRadio = null;

        parent::tearDown();
    }

    /**
     * Tests FormRadio->formRadio() with an array of selected items
     */
    public function testFormRadioWithAnArrayOfSelectedItems()
    {
        $formRadioStr = $this->formRadio->formRadio(
            array(
                1 => 'Yes',
                0 => 'No'
            ),
            'test.field',
            array(
                'onchange' => 'test();'
            ),
            array(1)
        );

        $searchFor = array(
            'onchange="test\(\);"',
            'type="radio"',
            'name="test\[field\]"',
            'id="test_field_1"',
            'value="1"',
            'checked="checked">',
            'Yes',
            'id="test_field_0"',
            'value="0"',
            'No'
        );

        foreach ($searchFor as $string) {
            $this->assertTrue((preg_match("@$string@", $formRadioStr) > 0), $formRadioStr);
        }
    }

    /**
     * Tests FormRadio->formRadio() with a selected item
     */
    public function testFormRadioWithaSelectedItem()
    {
        $formRadioStr = $this->formRadio->formRadio(
            array(
                1 => 'Yes',
                0 => 'No'
            ),
            'test.field',
            array(
                'onchange' => 'test();'
            ),
            0
        );

        $searchFor = array(
            'onchange="test\(\);"',
            'type="radio"',
            'name="test\[field\]"',
            'id="test_field_1"',
            'value="1"',
            'Yes',
            'id="test_field_0"',
            'value="0"',
            'No',
        );

        foreach ($searchFor as $string) {
            $this->assertTrue((preg_match("@$string@", $formRadioStr) > 0), $formRadioStr);
        }
    }

    /**
     * Tests FormRadio->formRadio() with no selected items
     */
    public function testFormRadioWithNoSelectedItems()
    {
        $formRadioStr = $this->formRadio->formRadio(
            array(
                1 => 'Yes',
                0 => 'No'
            ),
            'test.field',
            array(
                'onchange' => 'test();'
            )
        );

        $searchFor = array(
            'onchange="test\(\);"',
            'type="radio"',
            'name="test\[field\]"',
            'id="test_field_1"',
            'value="1"',
            'Yes',
            'id="test_field_0"',
            'value="0"',
            'No'
        );

        foreach ($searchFor as $string) {
            $this->assertTrue((preg_match("@$string@", $formRadioStr) > 0), $formRadioStr);
        }
    }
}

