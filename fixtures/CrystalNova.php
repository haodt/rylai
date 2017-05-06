<?php

namespace Rylai\Fixtures;

use Rylai\Fixtures\Items\Courier;
use Rylai\Fixtures\Traits\SlowEffect;

/**
 * Main support skill
 *
 * A burst of damaging frost slows enemy movement and attack rate in the targeted area
 */
class CrystalNova extends Skill
{
    use SlowEffect;

    const DAMAGE = "MAGIC";

    const RANGE = 500;

    /**
     * Cast Animation
     * @var float
     */
    public $castAnimation;

    /**
     * Cast Range
     * @var integer
     */
    public $castRange = 700;

    /**
     * Effect description
     *
     * Slow persists if debuff was placed before spell immunity and when not dispelled.
     * @var string
     */
    public $description;

    /**
     * Courier bought
     * @var Courier
     */
    protected $_courier;

    /**
     * The air temperature around Rylai drops rapidly, chilling all around her to the core.
     *
     * @todo test
     * @link http://github.com For example
     * @param mixed $mana Mana cost
     * @param Courier $courier Buy courier
     * @return void
     */
    public function cast($mana = 200, Courier $courier)
    {

    }

}
