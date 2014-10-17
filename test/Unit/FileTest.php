<?php

namespace Estey\EvernoteOCR;

function finfo_open()
{
}

function finfo_file($finfo, $string)
{
    return $string;
}

function finfo_close()
{
}

namespace Estey\EvernoteOCR\Test\Unit;

class FileTest extends TestCase
{
    /**
     * Set up tests.
     */
    public function setUp()
    {
        parent::setUp();
        $this->file = new \Estey\EvernoteOCR\File();
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

    /**
     * Test Getting Mimetype.
     */
    public function testGetMimetype()
    {
        $this->file->setPath('image/jpeg ; foo:bar');
        $this->assertEquals($this->file->getMimetype(), 'image/jpeg');

        $this->file->setPath('image/png');
        $this->assertEquals($this->file->getMimetype(), 'image/png');
    }
}
