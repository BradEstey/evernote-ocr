<?php

namespace Estey\EvernoteOCR\FileAdapters;

use Estey\EvernoteOCR\File;
use Estey\EvernoteOCR\FileInterface;
use Illuminate\Filesystem\Filesystem;

/**
 * Illuminate Filesystem Adapter
 *
 * This class is used to adapt the Laravel filesystem class to implement
 * the File Interface.
 */
class IlluminateFileAdapter extends File implements FileInterface
{
    /**
     * File path.
     * @var string
     */
    protected $path;

    /**
     * Filesystem.
     * @var Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * Illuminate Filesystem Adapter Class.
     * 
     * @param Illuminate\Filesystem\Filesystem $filesystem
     */
    public function __construct(
        Filesystem $filesystem = null
    ) {
        $this->filesystem = $filesystem;
    }
}
