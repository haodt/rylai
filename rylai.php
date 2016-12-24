#!/usr/bin/env php
<?php

require_once __DIR__ . "/vendor/autoload.php";

use Rylai\Console\Commands\ParseCommand;
use Symfony\Component\Console\Application;

$application = new Application;

$application->add(new ParseCommand);

$application->run();