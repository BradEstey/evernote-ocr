<?php

namespace Estey\EvernoteOCR\FileAdapters;

use Evernote\File\FileInterface;
use Illuminate\Filesystem\Filesystem;

/**
 * Illuminate Filesystem Adapter
 *
 * This class is used to adapt the Laravel filesystem class to implement
 * the Evernote\File\FileInterface.
 */
class IlluminateFileAdapter implements FileInterface
{
    /**
     * Filesystem.
     * @var Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * File Path.
     * @var string
     */
    protected $path;

    /**
     * Illuminate Filesystem Adapter Class.
     *
     * @param string $path
     * @param Illuminate\Filesystem\Filesystem $filesystem
     * @return void
     */
    public function __construct($path, Filesystem $filesystem)
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
        return $this->filesystem->get($this->path);
    }

    /**
     * Get the file's mimetype.
     * 
     * @return string
     */
    public function getMimetype()
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_buffer($finfo, $this->getContent());
        finfo_close($finfo);

        if (strpos($mime_type, ';') !== false) {
            list($mime_type, $info) = explode(';', $mime_type);
        }
        
        return trim($mime_type);
    }
}
