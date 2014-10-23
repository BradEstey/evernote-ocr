<?php

namespace Estey\EvernoteOCR;

use Exception;
use Estey\EvernoteOCR\Exceptions\ResourceException;
use Evernote\Model\Resource;
use Evernote\File\FileInterface;

/**
 * Resource Factory
 *
 * Since the Evernote\Model\Resource class requires data to be passed
 * in via the __construct() it can make it difficult to do dependency
 * injection in order to mock and test.
 */
class ResourceFactory
{
    /**
     * Make a new resource.
     * 
     * @param Evernote\File\FileInterface $file
     * @return Evernote\Model\Resource
     * @throws Estey\EvernoteOCR\Exceptions\ResourceException
     */
    public function make(FileInterface $file)
    {
        try {
            $resource = new Resource($file);
        } catch (Exception $e) {
            // If an exception occurs, rethrow it as a ResourceException.
            throw new ResourceException($e->getMessage());
        }

        return $resource;
    }
}
