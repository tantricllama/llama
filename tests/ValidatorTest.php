<?php
use Llama\Validator;

class ValidatorSubClass extends Validator
{
    // class body
}

class ValidatorTest extends PHPUnit_Framework_TestCase
{
    protected $validator;

    protected function setUp()
    {
        $this->validator = new ValidatorSubClass();
        $this->validator->setFields(
            array(
                'field_1' => 'Field 1',
                'field_2' => 'Field 2',
                'field_3' => 'Field 3',
                'field_4' => 'Field 4',
                'field_5' => 'Field 5',
                'field_6' => 'Field 6',
                'field_7' => 'Field 7',
                'field_8' => 'Field 8',
                'field_9' => 'Field 9',
                'field_10' => 'Field 10',
                'field_11' => 'Field 11'
            )
        );

        parent::setUp();
    }

    public function testSetCreateModeSetsModeToCreate()
    {
        $this->validator->setCreateMode();
        $this->assertAttributeEquals('create', 'mode', $this->validator);
    }

    public function testSetUpdateModeSetsModeToUpate()
    {
        $this->validator->setUpdateMode();
        $this->assertAttributeEquals('update', 'mode', $this->validator);
    }

    public function testHasErrorReturnsFalseWhenThereAreNoErrors()
    {
        $this->assertFalse($this->validator->hasErrors());
    }

    public function testHasErrorReturnsTrueWhenThereAreErrors()
    {
        $this->validator->setCreateMode();
        $this->validator->setPresenceOf(array('field_1'));
        $this->validator->execute(array());
        $this->assertTrue($this->validator->hasErrors());
    }

    public function testGetErrorReturnsAnEmptyArrayWhenThereAreNoErrors()
    {
        $this->assertEquals(array(), $this->validator->getErrors());
    }

    public function testGetErrorReturnsAnArrayWithAnErrorForaRequiredField()
    {
        $this->validator->setCreateMode();
        $this->validator->setPresenceOf(array('field_1'));
        $this->validator->execute(array());
        $this->assertEquals(array('field_1' => array('Field 1 is required')), $this->validator->getErrors());
    }

    /**
     * @expectedException \Llama\Validator\Exception
     */
    public function testExecuteThrowsAnExceptionWhenTheModeHasNotBeenSet()
    {
        $this->validator->execute(array());
    }

    /**
     * Sets up the ValidatorSubClass object with test fields/constraints for
     * testing the formatOf class
     */
    private function setUpFormatOf()
    {
        $this->validator->setFormatOf(
            array(
                'field_1' => array('if' => false),
                'field_2' => array('unless' => true),
                'field_3' => array('regex' => '/[a-z0-9]+/i', 'on' => 'update'),
                'field_4' => array('allow_blank' => true),
                'field_5' => array('allow_nil' => true),
                'field_6' => array('regex' => '/[a-z0-9]+/i')
            )
        );
    }

    /**
     * @depends testHasErrorReturnsFalseWhenThereAreNoErrors
     * @depends testHasErrorReturnsTrueWhenThereAreErrors
     * @depends testGetErrorReturnsAnEmptyArrayWhenThereAreNoErrors
     * @depends testGetErrorReturnsAnArrayWithAnErrorForaRequiredField
     */
    public function testFormatOfRaisesAnErrorForInvalidData()
    {
        $this->setUpFormatOf();
        $this->validator->setCreateMode();
        $this->validator->execute(array());
        $this->assertEquals(array('field_6' => array('Field 6 is invalid')), $this->validator->getErrors());
    }

    /**
     * @depends testFormatOfRaisesAnErrorForInvalidData
     */
    public function testFormatOfDoesntRaiseAnyErrorsWhenGivenValidData()
    {
        $this->setUpFormatOf();
        $this->validator->setUpdateMode();
        $this->validator->execute(
            array(
                'field_3' => 'valid123',
                'field_6' => 'valid456'
            )
        );
        $this->assertEquals(array(), $this->validator->getErrors());
    }

    /**
     * Sets up the ValidatorSubClass object with test fields/constraints for
     * testing the inclusionOf class
     */
    private function setUpInclusionOf()
    {
        $this->validator->setInclusionOf(
            array(
                'field_1' => array('if' => false),
                'field_2' => array('unless' => true),
                'field_3' => array('in' => array('one', 'two', 'three'), 'on' => 'update'),
                'field_4' => array('allow_blank' => true),
                'field_5' => array('allow_nil' => true),
                'field_6' => array('in' => array('one', 'two', 'three'))
            )
        );
    }

    /**
     * @depends testHasErrorReturnsFalseWhenThereAreNoErrors
     * @depends testHasErrorReturnsTrueWhenThereAreErrors
     * @depends testGetErrorReturnsAnEmptyArrayWhenThereAreNoErrors
     * @depends testGetErrorReturnsAnArrayWithAnErrorForaRequiredField
     */
    public function testInclusionOfRaisesAnErrorForInvalidData()
    {
        $this->setUpInclusionOf();
        $this->validator->setCreateMode();
        $this->validator->execute(array());
        $this->assertEquals(
            array(
                'field_6' => array('Field 6 is not included in the list')
            ),
            $this->validator->getErrors()
        );
    }

    /**
     * @depends testInclusionOfRaisesAnErrorForInvalidData
     */
    public function testInclusionOfDoesntRaiseAnyErrorsWhenGivenValidData()
    {
        $this->setUpInclusionOf();
        $this->validator->setUpdateMode();
        $this->validator->execute(
            array(
                'field_3' => 'one',
                'field_6' => 'two'
            )
        );
        $this->assertEquals(array(), $this->validator->getErrors());
    }

    /**
     * Sets up the ValidatorSubClass object with test fields/constraints for
     * testing the lengthOf class
     */
    private function setUpLengthOf()
    {
        $this->validator->setLengthOf(
            array(
                'field_1' => array('is_equal_to' => 4),
                'field_2' => array('is_equal_to' => 4, 'word_count' => true),
                'field_3' => array('minimum' => 1),
                'field_4' => array('minimum' => 1, 'word_count' => true),
                'field_5' => array('maximum' => 2),
                'field_6' => array('maximum' => 2, 'word_count' => true),
                'field_7' => array('minimum' => 1, 'maximum' => 5),
                'field_8' => array('minimum' => 1, 'maximum' => 5, 'word_count' => true),
                'field_9' => array('allow_nil' => true),
                'field_10' => array('allow_blank' => true)
            )
        );
    }

    /**
     * @depends testHasErrorReturnsFalseWhenThereAreNoErrors
     * @depends testHasErrorReturnsTrueWhenThereAreErrors
     * @depends testGetErrorReturnsAnEmptyArrayWhenThereAreNoErrors
     * @depends testGetErrorReturnsAnArrayWithAnErrorForaRequiredField
     */
    public function testLengthOfRaisesAnErrorForInvalidData()
    {
        $this->setUpLengthOf();
        $this->validator->setCreateMode();
        $this->validator->execute(
            array(
                'field_5' => 'three',
                'field_6' => 'one two three'
            )
        );
        $this->assertEquals(
            array(
                'field_1' => array('Field 1 is the wrong length (should be 4 characters)'),
                'field_2' => array('Field 2 is the wrong length (should be 4 words)'),
                'field_3' => array('Field 3 must be more than 1 character'),
                'field_4' => array('Field 4 must be more than 1 word'),
                'field_5' => array('Field 5 must be less than 2 characters'),
                'field_6' => array('Field 6 must be less than 2 words'),
                'field_7' => array('Field 7 must be between 1 and 5 characters'),
                'field_8' => array('Field 8 must be between 1 and 5 words')
            ),
            $this->validator->getErrors()
        );
    }

    /**
     * @depends testLengthOfRaisesAnErrorForInvalidData
     */
    public function testLengthOfDoesntRaiseAnyErrorsWhenGivenValidData()
    {
        $this->setUpLengthOf();
        $this->validator->setCreateMode();
        $this->validator->execute(
            array(
                'field_1' => 'four',
                'field_2' => 'one two three four',
                'field_3' => 'two',
                'field_4' => 'one two',
                'field_5' => '',
                'field_6' => '',
                'field_7' => 'four',
                'field_8' => 'one two three four'
            )
        );
        $this->assertEquals(array(), $this->validator->getErrors());
    }

    /**
     * Sets up the ValidatorSubClass object with test fields/constraints for
     * testing the numericalityOf class
     */
    private function setUpNumericalityOf()
    {
        $this->validator->setNumericalityOf(
            array(
                'field_1',
                'field_2' => array('if' => false),
                'field_3' => array('unless' => true),
                'field_4' => array('on' => 'update'),
                'field_5' => array('allow_nil' => true),
                'field_6' => array('only_integer' => true),
                'field_7' => array('greater_than' => 10),
                'field_8' => array('greater_than_or_equal_to' => 10),
                'field_9' => array('equal_to' => 10),
                'field_10' => array('less_than' => 10),
                'field_11' => array('less_than_or_equal_to' => 10)
            )
        );
    }

    /**
     * @depends testHasErrorReturnsFalseWhenThereAreNoErrors
     * @depends testHasErrorReturnsTrueWhenThereAreErrors
     * @depends testGetErrorReturnsAnEmptyArrayWhenThereAreNoErrors
     * @depends testGetErrorReturnsAnArrayWithAnErrorForaRequiredField
     */
    public function testNumericalityOfRaisesAnErrorForInvalidData()
    {
        $this->setUpNumericalityOf();
        $this->validator->setCreateMode();
        $this->validator->execute(
            array(
                'field_6' => 0.1,
                'field_7' => 9,
                'field_8' => 9,
                'field_9' => 9,
                'field_10' => 11,
                'field_11' => 11
            )
        );
        $this->assertEquals(
            array(
                'field_1' => array('Field 1 is not a number'),
                'field_6' => array('Field 6 is not an integer'),
                'field_7' => array('Field 7 is not greater than 10'),
                'field_8' => array('Field 8 is not greater than or equal to 10'),
                'field_9' => array('Field 9 is not equal to 10'),
                'field_10' => array('Field 10 is not less than 10'),
                'field_11' => array('Field 11 is not less than or equal to 10')
            ),
            $this->validator->getErrors()
        );
    }

    /**
     * @depends testNumericalityOfRaisesAnErrorForInvalidData
     */
    public function testNumericalityOfDoesntRaiseAnyErrorsWhenGivenValidData()
    {
        $this->setUpNumericalityOf();
        $this->validator->setCreateMode();
        $this->validator->execute(
            array(
                'field_1' => 1,
                'field_6' => 1,
                'field_7' => 11,
                'field_8' => 10,
                'field_9' => 10,
                'field_10' => 9,
                'field_11' => 9
            )
        );
        $this->assertEquals(array(), $this->validator->getErrors());
    }

    /**
     * Sets up the ValidatorSubClass object with test fields/constraints for
     * testing the presenceOf class
     */
    private function setUpPresenceOf()
    {
        $this->validator->setPresenceOf(
            array(
                'field_1',
                'field_2' => array('if' => false),
                'field_3' => array('unless' => true),
                'field_4' => array('on' => 'update'),
                'field_5' => array('message' => '%s has a custom error message')
            )
        );
    }

    /**
     * @depends testHasErrorReturnsFalseWhenThereAreNoErrors
     * @depends testHasErrorReturnsTrueWhenThereAreErrors
     * @depends testGetErrorReturnsAnEmptyArrayWhenThereAreNoErrors
     * @depends testGetErrorReturnsAnArrayWithAnErrorForaRequiredField
     */
    public function testPresenceOfRaisesAnErrorForInvalidData()
    {
        $this->setUpPresenceOf();
        $this->validator->setCreateMode();
        $this->validator->execute(array());
        $this->assertEquals(
            array(
                'field_1' => array('Field 1 is required'),
                'field_5' => array('Field 5 has a custom error message')
            ),
            $this->validator->getErrors()
        );
    }

    /**
     * @depends testPresenceOfRaisesAnErrorForInvalidData
     */
    public function testPresenceOfDoesntRaiseAnyErrorsWhenGivenValidData()
    {
        $this->setUpPresenceOf();
        $this->validator->setUpdateMode();
        $this->validator->execute(
            array(
                'field_1' => 'Test',
                'field_2' => 'Test',
                'field_3' => 'Test',
                'field_4' => 'Test',
                'field_5' => 'Test'
            )
        );
        $this->assertEquals(array(), $this->validator->getErrors());
    }
}

