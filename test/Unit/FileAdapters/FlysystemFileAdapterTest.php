<?php

namespace Estey\EvernoteOCR\Test\Unit\FileAdapters;

use Estey\EvernoteOCR\FileAdapters\FlysystemFileAdapter;
use Estey\EvernoteOCR\Test\Unit\TestCase;
use Mockery as m;

class FlysystemFileAdapterTest extends TestCase
{
    /**
     * Set up tests.
     */
    public function setUp()
    {
        parent::setUp();
        
        $this->flysystem = m::mock('League\Flysystem\FilesystemInterface');
        $this->adapter = m::mock('League\Flysystem\AdapterInterface');
        $this->file = new FlysystemFileAdapter(
            '/path/to/img.jpg',
            $this->flysystem
        );
    }

    /**
     * Test getContent() method.
     */
    public function testGetContent()
    {
        $this->flysystem
            ->shouldReceive('read')
            ->once()
            ->andReturn('foobar');

        $this->assertEquals($this->file->getContent(), 'foobar');
    }

    /**
     * Test getFilename() method.
     */
    public function testGetFilename()
    {
        $this->assertEquals($this->file->getFilename(), 'img.jpg');
    }

    /**
     * Test getMimetype() method.
     */
    public function testGetMimetype()
    {
        $this->flysystem
            ->shouldReceive('getMimetype')
            ->once()
            ->andReturn('image/jpeg');

        $this->assertEquals($this->file->getMimetype(), 'image/jpeg');
    }
}
