#!/usr/bin/env php
<?php

require_once __DIR__ . "/vendor/autoload.php";

use Rylai\Analyzers\Docblock;
use Rylai\Runner\AbstractRunner;
use Rylai\Stores\Local;

class Runner extends AbstractRunner
{
    public function getPaths()
    {
        return [
            "Rylai" => __DIR__ . "/src/",
        ];
    }

    public function getAnalyzers()
    {
        return [
            new Docblock,
        ];
    }

    public function getStores()
    {
        return [
            new Local([
                "views" => __DIR__ . "/views",
                "store" => __DIR__ . "/docs",
            ]),
        ];
    }
}

$runner = new Runner();
$runner->run();