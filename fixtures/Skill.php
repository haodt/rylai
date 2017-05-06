<?php

namespace Rylai\Fixtures;

use Rylai\Fixtures\Traits\SkillLevel;

/**
 * Parent class
 */
class Skill implements SkillInterface
{
    use SkillLevel;

    const RANGE = 400;

    const MAXRANGE = 80000;

    /**
     * Total trigger time
     * @var integer
     */
    protected $_triggered = 0;

    /**
     * Trigger item
     * @param  mixed $item
     * @return void
     */
    public function trigger($item)
    {

    }
}
