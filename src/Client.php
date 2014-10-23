<?php

namespace Estey\EvernoteOCR;

use Exception;
use Estey\EvernoteOCR\ResourceFactory;
use Estey\EvernoteOCR\Exceptions\ImageRecognitionException;
use Evernote\Client as Evernote;
use Evernote\Model\Note;
use Evernote\Model\Resource;
use Evernote\File\FileInterface;
use Evernote\File\File;

/**
 * Client
 *
 * The client class is the entry point into the Evernote OCR package that
 * manages all of the calls to the interactions with the Evernote PHP SDK,
 * parses the XML response and returns an array of TextBlock objects.
 */
class Client
{
    /**
     * Evernote SDK.
     * @var Evernote\Client
     */
    private $client;

    /**
     * File.
     * @var Evernote\File\FileInterface
     */
    private $file;

    /**
     * Resource Factory.
     * @var Estey\EvernoteOCR\ResourceFactory
     */
    private $resource_factory;

    /**
     * New Client.
     *
     * @param string $token
     * @param Evernote\File\FileInterface $file
     * @param Estey\EvernoteOCR\ResourceFactory $resource_factory
     * @param Evernote\Client $client
     * @return void
     */
    public function __construct(
        $token,
        FileInterface $file = null,
        ResourceFactory $resource_factory = null,
        Evernote $client = null
    ) {
        $this->file = $file;
        $this->resource_factory = $resource_factory ?: new ResourceFactory;
        $this->client = $client ?: new Evernote($token, false);
    }

    /**
     * Pass the location of the file to run text recognition on.
     * Returns an array of Estey\EvernoteOCR\TextBlock objects.
     * 
     * @param string $path
     * @param Evernote\Model\Note $note
     * @return Estey\EvernoteOCR\TextBlock[]
     */
    public function recognize($path = null, Note $note = null)
    {
        if (!$this->file instanceof FileInterface) {
            $this->file = new File($path);
        }

        // Create a note resource.
        $resource = $this->resource_factory->make($this->file);

        // Add the resource to a new Note.
        $note = $this->makeNote($resource, $note);

        // Upload note to Evernote API return the note data.
        $note = $this->saveNote($note);

        // Get text recognition.
        return $this->getRecognition($note);
    }

    /**
     * Make a new note or append to a note that has already been created.
     * 
     * @param Evernote\Model\Resource $resource
     * @param Evernote\Model\Note $note
     * @return Evernote\Model\Note
     */
    private function makeNote(Resource $resource, Note $note = null)
    {
        $note = $note ?: new Note;

        // Title and content are both required.
        // Only content can be an empty string.
        $note->setTitle('Evernote OCR');
        $note->setContent('');

        $note->addResource($resource);
        return $note;
    }

    /**
     * Upload Note to Evernote API.
     * 
     * @param Evernote\Model\Note $note
     * @return Evernote\Model\Note
     */
    private function saveNote(Note $note)
    {
        // Upload note to Evernote, get response.
        $note = $this->client->uploadNote($note);
        
        // Delete note from Evernote.
        $this->client->deleteNote($note);

        return $note;
    }

    /**
     * Take note and read the text recognition data.
     * Returns an array of Estey\EvernoteOCR\TextBlock objects.
     * 
     * @param Evernote\Model\Note $note
     * @return Estey\EvernoteOCR\TextBlock[]
     * @throws Estey\EvernoteOCR\Exceptions\ImageRecognitionException
     */
    private function getRecognition(Note $note)
    {
        // Get collection of resources from note.
        $resources = $note->getResources();
        $data = (array) $resources[0]->recognition;

        if (!isset($data['body'])) {
            throw new ImageRecognitionException(
                'No text found in image file.'
            );
        }

        return $this->parseTextBlocks($data['body']);
    }

    /**
     * Parse XML and returns an array of Estey\EvernoteOCR\TextBlock objects.
     * 
     * @param string $xml
     * @return Estey\EvernoteOCR\TextBlock[]
     */
    private function parseTextBlocks($xml)
    {
        $data = [];
        $currentItem = 0;

        $parser = xml_parser_create();
        xml_parse_into_struct($parser, $xml, $elements, $index);
        xml_parser_free($parser);
    
        foreach ($elements as $element) {
            if ($element['tag'] === 'ITEM' and $element['type'] === 'open') {
                $data[$currentItem] = new TextBlock(
                    (integer) $element['attributes']['X'],
                    (integer) $element['attributes']['Y'],
                    (integer) $element['attributes']['W'],
                    (integer) $element['attributes']['H']
                );
                continue;
            }

            if ($element['tag'] === 'ITEM' and $element['type'] === 'close') {
                $currentItem++;
                continue;
            }

            if ($element['tag'] === 'T') {
                $data[$currentItem]->addText(
                    (string) $element['value'],
                    (integer) $element['attributes']['W']
                );
            }
        }

        return $data;
    }
}
