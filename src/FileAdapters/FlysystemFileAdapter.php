<?php

namespace Estey\EvernoteOCR\FileAdapters;

use Evernote\File\FileInterface;
use League\Flysystem\FilesystemInterface;

/**
 * FlySystem File Adapter
 *
 * This class is used to adapt the FlySystem filesystem class to implement
 * the Evernote\File\FileInterface.
 */
class FlysystemFileAdapter implements FileInterface
{
    /**
     * Filesystem.
     * @var League\Flysystem\FilesystemInterface
     */
    protected $filesystem;

    /**
     * File Path.
     * @var string
     */
    protected $path;

    /**
     * FlySystem File Adapter Class.
     * 
     * @param string $path
     * @param League\Flysystem\FilesystemInterface $filesystem
     * @return void
     */
    public function __construct($path, FilesystemInterface $filesystem)
    {
        $this->path = $path;
        $this->filesystem = $filesystem;
    }

    /**
     * Get the filename.
     * 
     * @return string
     */
    public function getFilename()
    {
        $path = explode(DIRECTORY_SEPARATOR, $this->path);
        return array_pop($path);
    }

    /**
     * Get the file's content.
     * 
     * @return string
     */
    public function getContent()
    {
        return $this->filesystem->read($this->path);
    }

    /**
     * Get the file's mimetype.
     * 
     * @return string
     */
    public function getMimetype()
    {
        return $this->filesystem->getMimetype($this->path);
    }
}
