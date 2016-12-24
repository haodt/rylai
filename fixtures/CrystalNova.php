<?php

/**
 * A burst of damaging frost slows enemy movement and attack rate in the targeted area
 */
class CrystalNova
{
    const DAMAGE = "MAGIC";

    /**
     * Cast Animation
     * @var float
     */
    public $castAnimation = 0.3;

    /**
     * Cast Range
     * @var integer
     */
    public $castRange = 700;

    /**
     * Effect description
     * @var string
     */
    public $description = "Slow persists if debuff was placed before spell immunity and when not dispelled.";

    /**
     * The air temperature around Rylai drops rapidly, chilling all around her to the core.
     * @param  any $mana Mana cost
     * @return void
     */
    public function cast($mana)
    {

    }

}
