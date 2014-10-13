<?php

namespace Estey\EvernoteOCR;

/**
 * Text
 *
 * A simple class for managing the text string returned from the Evernote API.
 * Includes the confidence score.
 */
class Text
{
    /**
     * Text.
     * @var string
     */
    public $text;

    /**
     * Confidence Score. Between 0 and 100.
     * @var integer
     */
    public $confidence;

    /**
     * New Text Element.
     * 
     * @param string $text
     * @param integer $confidence
     * @return void
     */
    public function __construct($text, $confidence)
    {
        $this->text = $text;
        $this->confidence = $confidence;
    }

    /**
     * Text Length.
     * 
     * @return integer|boolean
     */
    public function length($length = null)
    {
        if ($length) {
            return strlen($this->text) === $length;
        }

        return strlen($this->text);
    }

    /**
     * Is text all uppercase?
     * 
     * @return boolean
     */
    public function isUppercase()
    {
        return strtoupper($this->text) === $this->text;
    }

    /**
     * Is text all lowercase?
     * 
     * @return boolean
     */
    public function isLowercase()
    {
        return strtolower($this->text) === $this->text;
    }
}
