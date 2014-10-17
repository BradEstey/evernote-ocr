<?php

namespace Estey\EvernoteOCR\Test\Unit;

use Estey\EvernoteOCR\Client;
use Mockery as m;

class ClientTest extends TestCase
{
    /**
     * The name of the class being tested.
     * @var string
     */
    public static $className = 'Estey\EvernoteOCR\Client';

    /**
     * Set up tests.
     */
    public function setUp()
    {
        parent::setUp();
        
        $this->evernote = m::mock('Evernote\Client', [123, false]);
        $this->file = m::mock('Estey\EvernoteOCR\FileInterface');
        $this->note = m::mock('Evernote\Model\Note');
        $this->resource = m::mock('Evernote\Model\Resource');

        // Text Recognition Stub.
        $this->recognition = file_get_contents(
            __DIR__ . '/../Stubs/recognition.xml'
        );

        $this->client = new Client(123, $this->file, $this->evernote);
    }

    /**
     * Test the recognize() method.
     */
    public function testRecognize()
    {
        $this->makeNote();
        $this->saveNote();
        $this->getRecognition();

        $response = $this->client->recognize(
            'path/to/image.jpg',
            $this->resource,
            $this->note
        );

        $this->verifyResponse($response);
    }

    /**
     * Test the makeResource() method.
     * 
     * @expectedException Estey\EvernoteOCR\Exceptions\ResourceException
     */
    public function testMakeResource()
    {
        $this->file
            ->shouldReceive('setPath')
            ->once()
            ->with('path/to/image.jpg')
            ->andReturn($this->file);

        $this->file
            ->shouldReceive('getPath')
            ->once()
            ->andReturn('path/to/image.jpg');

        $this->file
            ->shouldReceive('getMimetype')
            ->once()
            ->andReturn('image/jpeg');

        // This will throw an exception because 'path/to/image.jpg'
        // doesn't exist.
        $resource = $this->callMethod(
            $this->client,
            'makeResource',
            ['path/to/image.jpg']
        );
    }

    /**
     * What fires when makeNote() is called.
     */
    private function makeNote()
    {
        $this->note
            ->shouldReceive('setTitle')
            ->once()
            ->with('Evernote OCR');

        $this->note
            ->shouldReceive('setContent')
            ->once()
            ->with('');

        $this->note
            ->shouldReceive('addResource')
            ->once()
            ->with($this->resource);
    }

    /**
     * Test the makeNote() method.
     */
    public function testMakeNote()
    {
        $this->makeNote();

        $note = $this->callMethod(
            $this->client,
            'makeNote',
            [$this->resource, $this->note]
        );

        $this->assertEquals($note, $this->note);
    }

    /**
     * What fires when saveNote() is called.
     */
    private function saveNote()
    {
        $this->evernote
            ->shouldReceive('uploadNote')
            ->once()
            ->with($this->note)
            ->andReturn($this->note);

        $this->evernote
            ->shouldReceive('deleteNote')
            ->once()
            ->with($this->note);
    }

    /**
     * Test the saveNote() method.
     */
    public function testSaveNote()
    {
        $this->saveNote();

        $note = $this->callMethod(
            $this->client,
            'saveNote',
            [$this->note]
        );

        $this->assertEquals($note, $this->note);
    }

    /**
     * What fires when getRecognition() is called.
     *
     * @param array $recognition
     */
    private function getRecognition($recognition = null)
    {
        $recognition = $recognition ?: ['body' => $this->recognition];
        
        $this->note
            ->shouldReceive('getResources')
            ->once()
            ->andReturn([
                (object) [
                    'recognition' => $recognition
                ]
            ]);
    }

    /**
     * Test getRecognition() method.
     */
    public function testGetRecognition()
    {
        $this->getRecognition();

        $response = $this->callMethod(
            $this->client,
            'getRecognition',
            [$this->note]
        );

        $this->verifyResponse($response);
    }

    /**
     * Verify Response.
     * 
     * @param array $response
     */
    private function verifyResponse($response)
    {
        $this->assertTrue(is_array($response));
        $this->assertEquals(count($response), 2);
        $text = $response[0]->options;
        $this->assertEquals($text[0]->text, 'EVER ?');
        $this->assertEquals($text[0]->confidence, 87);
        $this->assertEquals($text[1]->text, 'EVER NOTE');
        $this->assertEquals($text[2]->text, 'EVERNOTE');

        $text = $response[1]->options;
        $this->assertEquals($text[0]->text, 'et');
        $this->assertEquals($text[0]->confidence, 11);
        $this->assertEquals($text[1]->text, 'TQ');
        $this->assertEquals($text[0]->length(), 2);
        $this->assertTrue($text[0]->length(2));
        $this->assertFalse($text[0]->length(5));
        $this->assertTrue($text[0]->isLowercase());
        $this->assertTrue($text[1]->isUppercase());
    }

    /**
     * Test getRecognition() method fails.
     *
     * @expectedException Estey\EvernoteOCR\Exceptions\ImageRecognitionException
     */
    public function testGetRecognitionFails()
    {
        $this->getRecognition(['foo' => 'bar']);
        $this->callMethod(
            $this->client,
            'getRecognition',
            [$this->note]
        );
    }
}
