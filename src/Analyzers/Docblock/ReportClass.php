<?php

namespace Rylai\Analyzers\Docblock;

use Go\ParserReflection\ReflectionClass;
use phpDocumentor\Reflection\Docblock;
use phpDocumentor\Reflection\DocblockFactory;

/**
 * Report class properties , constant , methods
 */
class ReportClass extends AbstractReport
{
    public function __construct()
    {
        parent::__construct();
        $this->_alloweds = array_merge(
            $this->_alloweds,
            ["constants", "properties", "methods", "interfaces", "traits", "parents"]
        );
    }

    /**
     * Loop through classes to generate classes report
     * @param  ReflectionClass $target
     * @param  DocblockFactory $factory
     * @param  Docblock        $docblock
     * @return void
     */
    protected function _afterParse(ReflectionClass $target, DocblockFactory $factory, Docblock $docblock)
    {
        $constants  = [];
        $properties = [];
        $methods    = [];
        $parents    = [];
        $traits     = $target->getTraitNames();

        $parent = $target->getParentClass();
        while ($parent) {

            $parents[] = $parent->getName();
            $traits    = array_merge($traits, $parent->getTraitNames());
            $parent    = $parent->getParentClass();

        }

        $this->traits     = $traits;
        $this->interfaces = $target->getInterfaceNames();
        $this->parents    = $parents;

        foreach ($target->getConstants() as $constant => $value) {
            $constants[] = [
                "name"  => $constant,
                "value" => $value,
                "type"  => gettype($value),
            ];
        }

        foreach ($target->getProperties() as $property) {

            $report = new ReportProperty();
            $report->parse($property, $factory);

            $properties[] = $report;
        }

        foreach ($target->getMethods() as $method) {
            $report = new ReportMethod();
            $report->parse($method, $factory);

            $methods[] = $report;
        }

        $this->constants  = $constants;
        $this->properties = $properties;
        $this->methods    = $methods;
    }
}
