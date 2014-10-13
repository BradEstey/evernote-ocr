<?php

namespace Estey\EvernoteOCR\FileAdapters;

use Estey\EvernoteOCR\File;
use Estey\EvernoteOCR\FileInterface;
use League\Flysystem\FilesystemInterface;

/**
 * FlySystem File Adapter
 *
 * This class is used to adapt the FlySystem file class to implement
 * the File Interface.
 */
class FlySystemFileAdapter extends File implements FileInterface
{
    /**
     * Filesystem.
     * @var League\Flysystem\FilesystemInterface
     */
    protected $filesystem;

    /**
     * FlySystem File Class.
     * 
     * @param League\Flysystem\FilesystemInterface $filesystem
     */
    public function __construct(
        FilesystemInterface $filesystem = null
    ) {
        $this->filesystem = $filesystem;
    }

    /**
     * Get full file path.
     * 
     * @return string
     */
    public function getPath()
    {
        $pathPrefix = $this->filesystem->getAdapter()->getPathPrefix();
        return $pathPrefix . $this->path;
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
