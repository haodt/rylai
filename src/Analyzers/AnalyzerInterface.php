<?php

namespace Rylai\Analyzers;

use Rylai\Reflection\File;

interface AnalyzerInterface
{
    public function analyze(File $file);
}
