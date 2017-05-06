<?php

namespace Rylai\Fixtures\Traits;

/**
 * Slowing target
 */
trait SkillLevel
{
    /**
     * Skill level
     * @var integer
     */
    protected $_level = 1;

    /**
     * Set skill level
     * @param int $level
     */
    public function levelUpSkill($level)
    {
        $this->_level = $level;
    }
}
