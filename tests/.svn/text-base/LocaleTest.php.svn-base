<?php
use Llama\Locale;

class LocaleTest extends PHPUnit_Framework_TestCase
{

    /**
     * Test the Constructor of the Locale class:
     *  - ensure the private locale property is null when no locale is passed to the constructor
     *  - ensure the private locale property matches the locale that is passed to the constructor
     */
    public function testLocale()
    {
        $this->assertAttributeEquals(null, 'locale', new Locale());
        $this->assertAttributeEquals('en_AU', 'locale', new Locale('en_AU'));
    }

    /**
     * Test the setLocale method of the Locale class:
     *  - ensure the private locale property matches the value passed
     *  - ensure the private initialised property is false
     */
    public function testSetLocale()
    {
        $locale = new Locale();
        $locale->setLocale('en_AU');

        $this->assertAttributeEquals('en_AU', 'locale', $locale);
        $this->assertAttributeEquals(false, 'initialised', $locale);
    }

    /**
     * Test the getLocale method of the Locale class:
     *  - ensure the getLocale method returns the value passed to setLocale
     */
    public function testGetLocale()
    {
        $locale = new Locale();
        $locale->setLocale('en_AU');

        $this->assertEquals('en_AU', $locale->getLocale());
    }

    /**
     * Test the setPath method of the Locale class:
     *  - ensure the private path property matches the value passed
     */
    public function testSetPath()
    {
        $locale = new Locale();
        $locale->setPath('./');

        $this->assertAttributeEquals('./', 'path', $locale);
    }

    /**
     * Test the getPath method of the Locale class:
     *  - ensure the getPath method returns the value passed to setPath
     */
    public function testGetPath()
    {
        $locale = new Locale();
        $locale->setPath('./');

        $this->assertEquals('./', $locale->getPath());
    }

    /**
     * Test the setCharset method of the Locale class:
     *  - ensure the private charset property matches the value passed
     */
    public function testSetCharset()
    {
        $locale = new Locale();
        $locale->setCharset('UTF-8');

        $this->assertAttributeEquals('UTF-8', 'charset', $locale);
    }

    /**
     * Test the getCharset method of the Locale class:
     *  - ensure the getCharset method returns the value passed to setCharset
     */
    public function testGetCharset()
    {
        $locale = new Locale();
        $locale->setCharset('UTF-8');

        $this->assertEquals('UTF-8', $locale->getCharset());
    }

    /**
     * Test the translate method of the Locale class:
     *  - ensure the translate method returns the translated string
     */
    public function testTranslate()
    {
        $locale = new Locale();
        $locale->setLocale('en_AU');
        $locale->setPath('./');

        $this->assertEquals('testing this', $locale->translate('locale_test', 'testing this'));
        $this->assertEquals('testing that', $locale->translate('locale_test', 'testing %s', 'that'));
    }

    /**
     * Test the __toString method of the Locale class:
     *  - ensure the __toString method is invoked when the object is used in the context of a string
     */
    public function testToString()
    {
        $locale = new Locale('en_AU');

        $this->assertTrue($locale == 'en_AU');
    }
}

