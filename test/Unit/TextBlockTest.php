<?php

namespace Estey\EvernoteOCR\Test\Unit;

use Estey\EvernoteOCR\TextBlock;
use Mockery as m;

class TextBlockTest extends TestCase
{
    /**
     * Set up tests.
     */
    public function setUp()
    {
        parent::setUp();

        $this->textBlock = new TextBlock(10, 10, 300, 200);
        $this->text = m::mock('Estey\EvernoteOCR\Text');
        $this->text2 = m::mock('Estey\EvernoteOCR\Text');
    }

    /**
     * Test basic getter and setters.
     */
    public function testGetterSetter()
    {
        $this->assertEquals($this->textBlock->x, 10);
        $this->assertEquals($this->textBlock->y, 10);
        $this->assertEquals($this->textBlock->width, 300);
        $this->assertEquals($this->textBlock->height, 200);
        $this->assertEquals($this->textBlock->options, []);
    }

    /**
     * Test addText() method.
     */
    public function testAddText()
    {
        $this->assertEquals($this->textBlock->options, []);

        // Add new Text('Foo', 100)
        $this->textBlock->addText('Foo', 100);
        $this->assertTrue(
            is_a($this->textBlock->options[0], 'Estey\EvernoteOCR\Text')
        );
        $this->assertEquals(
            $this->textBlock->options[0]->text,
            'Foo'
        );
        $this->assertEquals(
            $this->textBlock->options[0]->confidence,
            100
        );

        // Add new Text('Bar', 85)
        $this->textBlock->addText('Bar', 85);
        $this->assertTrue(
            is_a($this->textBlock->options[1], 'Estey\EvernoteOCR\Text')
        );
        $this->assertEquals(
            $this->textBlock->options[1]->text,
            'Bar'
        );
        $this->assertEquals(
            $this->textBlock->options[1]->confidence,
            85
        );
    }

    /**
     * Test adding text to a text block using a Text object
     * in the first parameter.
     */
    public function testAddTextObject()
    {
        $this->textBlock->addText($this->text);
        $this->assertEquals(
            $this->textBlock->options,
            [$this->text]
        );

        $this->textBlock->addText($this->text2);
        $this->assertEquals(
            $this->textBlock->options,
            [$this->text, $this->text2]
        );
    }

    /**
     * Test leaving confidence empty.
     * 
     * @expectedException Estey\EvernoteOCR\Exceptions\InvalidArgumentException
     */
    public function testAddTextEmptyConfidence()
    {
        $this->textBlock->addText('foo bar');
    }

    /**
     * Test non-string in the first parameter.
     * 
     * @expectedException Estey\EvernoteOCR\Exceptions\InvalidArgumentException
     */
    public function testAddTextNotAString()
    {
        $this->textBlock->addText(1);
    }
}
