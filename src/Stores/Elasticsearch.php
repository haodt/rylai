<?php

namespace Rylai\Stores;

class Elasticsearch implements StoreInterface
{
    public function __construct($options)
    {

    }

    public function store(\stdClass $report)
    {
        var_dump(json_encode($report));
    }
}
