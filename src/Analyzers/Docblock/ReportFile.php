<?php

namespace Rylai\Analyzers\Docblock;

use Go\ParserReflection\ReflectionFile;
use phpDocumentor\Reflection\Docblock;
use phpDocumentor\Reflection\DocBlockFactory;

/**
 * Report of analyzed file
 */
class ReportFile extends AbstractReport
{
    public function __construct()
    {
        parent::__construct();
        $this->_alloweds = array_merge($this->_alloweds, ["namespaces"]);
    }

    /**
     * Loop through namespaces to generate namespace report
     * @param  ReflectionFile   $target
     * @param  DocBlockFactory  $factory
     * @param  Docblock         $docblock
     * @return void
     */
    protected function _afterParse(ReflectionFile $target, DocBlockFactory $factory, Docblock $docblock)
    {
        $namespaces = [];

        foreach ($target->getFileNamespaces() as $namespace) {
            $report = new ReportNamespace();
            $report->parse($namespace, $factory);

            $namespaces[] = $report;
        }

        $this->namespaces = $namespaces;
    }
}
