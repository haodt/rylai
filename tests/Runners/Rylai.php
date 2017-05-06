<?php

namespace Rylai\Tests\Runners;

use Rylai\Runner\AbstractRunner;

/**
 * Runner to scan fixtures folder
 */
class Rylai extends AbstractRunner
{
    /**
     * Get target path
     * @return string[]
     */
    public function getPaths()
    {
        return [
            "fixture" => __DIR__ . "/../../fixtures/",
        ];
    }

    /**
     * Get analyzers
     * @return AnalyzerInterface[]
     */
    public function getAnalyzers()
    {
        return [];
    }

    /**
     * Get stores
     * @return StoreInterface[]
     */
    public function getStores()
    {
        return [];
    }

}
