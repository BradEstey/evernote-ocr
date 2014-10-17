<?php

namespace Estey\EvernoteOCR;

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
        // Using the finfo function versions because
        // HHVM has a problem mocking the Finfo class.
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimetype = finfo_file($finfo, $this->path);
        finfo_close($finfo);

        if (strpos($mimetype, ';') !== false) {
            list($mimetype, $info) = explode(';', $mimetype);
        }
        
        return trim($mimetype);
    }
}
