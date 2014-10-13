<?php

namespace Estey\EvernoteOCR;

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
     * @param string $text
     * @param integer $confidence
     */
    public function addText($text, $confidence)
    {
        $this->options[] = new Text($text, $confidence);
    }
}
