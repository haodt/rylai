<?php
/**
 * Items available in game
 */
namespace Items;

/**
 * Courier will delivery your items to you , be aware that people like to kill it
 */
class Courier
{
    /**
     * Price in gold for standard one
     * @var integer
     */
    public $price = 150;

    /**
     * Price in gold for upgrading to flying one , faster but more valuable !
     * @var integer
     */
    public $upgrade = 250;
}
