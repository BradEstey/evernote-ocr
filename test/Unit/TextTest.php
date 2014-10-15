<?php

namespace Estey\EvernoteOCR\Test\Unit;

use Estey\EvernoteOCR\Text;

class TextTest extends TestCase
{
    /**
     * Test basic getter and setters.
     */
    public function testGetterSetter()
    {
        $text = new Text('Foo bar', 100);
        $this->assertEquals($text->text, 'Foo bar');
        $this->assertEquals($text->confidence, 100);
    }

    /**
     * Test isUppercase() method.
     */
    public function testIsUppercase()
    {
        $text = new Text('Foo bar', 100);
        $this->assertFalse($text->isUppercase());

        $text = new Text('FOO BAR', 100);
        $this->assertTrue($text->isUppercase());
    }

    /**
     * Test isLowercase() method.
     */
    public function testIsLowercase()
    {
        $text = new Text('Foo bar', 100);
        $this->assertFalse($text->isLowercase());

        $text = new Text('foo bar', 100);
        $this->assertTrue($text->isLowercase());
    }

    /**
     * Test length() method.
     */
    public function testLength()
    {
        $text = new Text('Foo bar', 100);
        $this->assertTrue($text->length(7));
        $this->assertFalse($text->length(6));
        $this->assertEquals($text->length(), 7);
    }

    /**
     * Test setting confidence to a non-integer.
     * 
     * @expectedException InvalidArgumentException
     */
    public function testConfidenceNotAnInteger()
    {
        new Text('Foo bar', 'foo');
    }

    /**
     * Test setting confidence to more than 100.
     * 
     * @expectedException InvalidArgumentException
     */
    public function testConfidenceMoreThan100()
    {
        new Text('Foo bar', 101);
    }

    /**
     * Test setting confidence to less than 0.
     * 
     * @expectedException InvalidArgumentException
     */
    public function testConfidenceLessThan0()
    {
        new Text('Foo bar', -1);
    }

    /**
     * Test setting confidence to less than 0.
     * 
     * @expectedException InvalidArgumentException
     */
    public function testConfidenceWrongType()
    {
        new Text('Foo bar', '50');
    }
}
