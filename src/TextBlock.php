<?php

namespace Estey\EvernoteOCR;

use Estey\EvernoteOCR\Exceptions\InvalidArgumentException;

/**
 * Text Block
 *
 * A class for managing blocks of text returned by the Evernote API.
 * Includes the coordinates or the text found, the width/height, and 
 * the an instance of the text class for each string.
 */
class TextBlock
{
    /**
     * X Coordinates of Text Block.
     * @var integer
     */
    public $x;

    /**
     * Y Coordinates of Text Block.
     * @var integer
     */
    public $y;

    /**
     * Width of Text Block.
     * @var integer
     */
    public $width;

    /**
     * Height of Text Block.
     * @var integer
     */
    public $height;

    /**
     * Text Options.
     * @var array
     */
    public $options = [];

    /**
     * New TextBlock.
     * 
     * @param integer $x
     * @param integer $y
     * @param integer $width
     * @param integer $height
     * @return void
     */
    public function __construct($x, $y, $width, $height)
    {
        $this->x = $x;
        $this->y = $y;
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * Add a text option to this text block with confidence percentage.
     * 
     * @param string|Estey\EvernoteOCR\Text $text
     * @param integer|null $confidence
     * @return $this
     * @throws Estey\EvernoteOCR\Exceptions\InvalidArgumentException
     */
    public function addText($text, $confidence = null)
    {
        if (is_object($text)) {
            return $this->addTextObject($text);
        }

        if (is_string($text)) {
            // Throw an exception if $confidence is left empty.
            if (!$confidence) {
                throw new InvalidArgumentException(
                    'Second parameter is required when ' .
                    'first parameter is a string'
                );
            }

            $this->options[] = new Text($text, $confidence);
            return $this;
        }

        throw new InvalidArgumentException(
            'First parameter must be a string or an instance of ' .
            'Estey\EvernoteOCR\Text'
        );
    }

    /**
     * Add a text object to this text block.
     * 
     * @param Estey\EvernoteOCR\Text $text
     * @return $this
     */
    private function addTextObject(Text $text)
    {
        $this->options[] = $text;
        return $this;
    }
}
