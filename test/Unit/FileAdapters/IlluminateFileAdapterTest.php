<?php

namespace Estey\EvernoteOCR\Test\Unit\FileAdapters;

use Estey\EvernoteOCR\FileAdapters\IlluminateFileAdapter;
use Estey\EvernoteOCR\Test\Unit\TestCase;
use Mockery as m;

class IlluminateFileAdapterTest extends TestCase
{
    /**
     * Set up tests.
     */
    public function setUp()
    {
        parent::setUp();
        
        $this->filesystem = m::mock('Illuminate\Filesystem\Filesystem');
        $this->file = new IlluminateFileAdapter($this->filesystem);
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
