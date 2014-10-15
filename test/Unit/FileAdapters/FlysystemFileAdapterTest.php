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
        $this->file = new FlysystemFileAdapter($this->flysystem);
    }

    /**
     * Test getPath() method.
     */
    public function testGetPath()
    {
        $this->file->setPath('/to/image.jpg');

        $this->flysystem
            ->shouldReceive('getAdapter')
            ->once()
            ->andReturn($this->adapter);

        $this->adapter
            ->shouldReceive('getPathPrefix')
            ->once()
            ->andReturn('/full/path');

        $this->assertEquals($this->file->getPath(), '/full/path/to/image.jpg');
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
