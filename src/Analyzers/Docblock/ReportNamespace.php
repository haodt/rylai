<?php

namespace Rylai\Analyzers\Docblock;

use Go\ParserReflection\ReflectionFileNamespace;
use phpDocumentor\Reflection\Docblock;
use phpDocumentor\Reflection\DocBlockFactory;

/**
 * Report namespace
 */
class ReportNamespace extends AbstractReport
{

    public function __construct()
    {
        parent::__construct();
        $this->_alloweds = array_merge($this->_alloweds, ["classes", "aliases"]);
    }

    /**
     * Loop through classes to generate classes report
     * @param  ReflectionFileNamespace  $target
     * @param  DocBlockFactory          $factory
     * @param  Docblock                 $docblock
     * @return void
     */
    protected function _afterParse(ReflectionFileNamespace $target, DocBlockFactory $factory, Docblock $docblock)
    {
        $aliases = [];

        foreach ($target->getNamespaceAliases() as $fullname => $alias) {
            $aliases[] = [
                "name"  => $fullname,
                "alias" => $alias,
            ];
        }

        $this->aliases = $aliases;

        $classes = [];

        foreach ($target->getClasses() as $class) {
            $report = new ReportClass;
            $report->parse($class, $factory);

            $classes[] = $report;
        }

        $this->classes = $classes;
    }
}
