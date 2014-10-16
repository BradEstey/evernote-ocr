<?php

namespace Estey\EvernoteOCR;

use Finfo;

/**
 * File
 *
 * A simple local file class.
 */
class File
{
    /** 
     * File path.
     * @var string
     */
    protected $path;

    /**
     * Set the file path.
     * 
     * @param string $path
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Get full file path.
     * 
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get the file's mimetype.
     *
     * @return string
     */
    public function getMimetype()
    {
        $this->finfo = new Finfo(FILEINFO_MIME_TYPE);
        return $this->finfo->file($this->path);
    }
}
