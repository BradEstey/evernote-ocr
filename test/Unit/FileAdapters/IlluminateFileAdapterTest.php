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
        $this->file = new IlluminateFileAdapter(
            '/path/to/image.jpg',
            $this->filesystem
        );
    }

    /**
     * Test getContent() method.
     */
    public function testGetContent()
    {
        $this->filesystem
            ->shouldReceive('get')
            ->once()
            ->andReturn('foobar');

        $this->assertEquals($this->file->getContent(), 'foobar');
    }

    /**
     * Test getFilename() method.
     */
    public function testGetFilename()
    {
        $this->assertEquals($this->file->getFilename(), 'image.jpg');
    }

    /**
     * Test getMimetype() method.
     */
    public function testGetMimetype()
    {
        $this->filesystem
            ->shouldReceive('get')
            ->once()
            ->andReturn(file_get_contents(__DIR__ . '/../../Stubs/image.jpg'));

        $this->assertEquals($this->file->getMimetype(), 'image/jpeg');

        $this->filesystem
            ->shouldReceive('get')
            ->once()
            ->andReturn('Plain text file.');
        $this->assertEquals($this->file->getMimetype(), 'text/plain');
    }
}
