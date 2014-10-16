<?php

namespace Estey\EvernoteOCR;

use Estey\EvernoteOCR\Exceptions\InvalidArgumentException;

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
        $this->setText($text);
        $this->setConfidence($confidence);
    }

    /**
     * Set text.
     * 
     * @param string $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * Set confidence score.
     * 
     * @param integer $confidence
     * @return $this
     * @throws Estey\EvernoteOCR\Exceptions\InvalidArgumentException
     */
    public function setConfidence($confidence)
    {
        if (!is_int($confidence) or $confidence < 0 or $confidence > 100) {
            throw new InvalidArgumentException(
                'Confidence score must be an integer between 0 and 100.'
            );
        }
        $this->confidence = $confidence;
        return $this;
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
