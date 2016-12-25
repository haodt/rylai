<?php

namespace Rylai\Stores;

class Local implements StoreInterface
{

    protected $_store;

    public function __construct($store)
    {
        if (!file_exists($store)) {
            throw new \Exception("[$store] must be exists and writable");
        }
        $this->_store = $store;
    }

    public function store(\stdClass $report)
    {
        file_put_contents($this->_store . md5($report->file) . ".json", json_encode($report, JSON_PRETTY_PRINT));
    }
}
