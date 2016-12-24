<?php

namespace Rylai\Stores;

class Local implements StoreInterface
{
    public function store(\stdClass $report)
    {
        var_dump(json_encode($report, JSON_PRETTY_PRINT));
    }
}
