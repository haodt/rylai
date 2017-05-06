<?php

namespace Rylai\Runner;

interface RunnerInterface
{

    public function getPaths();

    public function getAnalyzers();

    public function getStores();

    public function getRepositories();

    public function run();

}
