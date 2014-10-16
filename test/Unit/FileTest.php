<?php

namespace Estey\EvernoteOCR\Test\Unit;

use Estey\EvernoteOCR\File;

class FileTest extends TestCase
{
    /**
     * Set up tests.
     */
    public function setUp()
    {
        parent::setUp();
        $this->file = new File();
    }

    /**
     * Test Setting and Getting Path.
     */
    public function testSetAndGetPath()
    {
        $this->assertEquals(
            $this->file->setPath('path/to/image.jpg'),
            $this->file
        );

        $this->assertEquals(
            $this->file->getPath(),
            'path/to/image.jpg'
        );
    }
}
