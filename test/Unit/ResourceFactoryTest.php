<?php

namespace Estey\EvernoteOCR\Test\Unit;

use Estey\EvernoteOCR\ResourceFactory;
use Mockery as m;

class ResourceFactoryTest extends TestCase
{
    /**
     * The name of the class being tested.
     * @var string
     */
    public static $className = 'Estey\EvernoteOCR\ResourceFactory';

    /**
     * Set up tests.
     */
    public function setUp()
    {
        parent::setUp();

        $this->file = m::mock('Evernote\File\FileInterface');
        $this->stub = new ResourceFactory;
    }

    /**
     * Test make() method.
     */
    public function testMake()
    {
        $this->file
            ->shouldReceive('getContent')
            ->once();

        $this->file
            ->shouldReceive('getMimeType')
            ->once();

        $this->file
            ->shouldReceive('getFilename')
            ->once();

        $resource = $this->stub->make($this->file);
        $this->assertEquals(get_class($resource), 'Evernote\Model\Resource');
    }


    /**
     * Test make() method throws exception.
     *
     * @expectedException Estey\EvernoteOCR\Exceptions\ResourceException
     */
    public function testMakeException()
    {
        $this->file
            ->shouldReceive('getContent')
            ->once()
            ->andThrow(new \Estey\EvernoteOCR\Exceptions\ResourceException);
        $this->stub->make($this->file);
    }
}
