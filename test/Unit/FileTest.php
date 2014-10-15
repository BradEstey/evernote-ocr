<?php

namespace Estey\EvernoteOCR\Test\Unit;

use Estey\EvernoteOCR\File;
use Mockery as m;

class FileTest extends TestCase
{
    /**
     * Set up tests.
     */
    public function setUp()
    {
        parent::setUp();

        $this->file = new File();
        $this->finfo = m::mock('Finfo');
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
        $this->setProtected($this->file, 'finfo', $this->finfo);
        $this->file->setPath('path/to/image.jpg');

        $this->finfo
            ->shouldReceive('file')
            ->once()
            ->with('path/to/image.jpg')
            ->andReturn('image/jpeg');
        $this->assertEquals($this->file->getMimetype(), 'image/jpeg');
    }
}
