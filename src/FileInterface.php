<?php

namespace Estey\EvernoteOCR;

/**
 * File Interface
 *
 * Use this interface to swap out the simple local file class with
 * something else.
 */
interface FileInterface
{
    /**
     * Set the file path.
     * 
     * @param string $path
     * @return $this
     */
    public function setPath($path);

    /**
     * Get full file path.
     * 
     * @return string
     */
    public function getPath();

    /**
     * Get the file's mimetype.
     * 
     * @return string
     */
    public function getMimetype();
}
