<?php

namespace Rylai\Fixtures\Traits;

/**
 * Slowing target
 */
trait SlowEffect
{
    /**
     * Slow duration
     *
     * Calculate by seconds
     * @var integer
     */
    protected $_duration = 500;

    /**
     * Set slow duration
     * @param int $duration
     * @return void
     */
    public function setSlowDuration($duration)
    {
        $this->_duration = $duration;
    }
}
