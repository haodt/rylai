<?php

namespace Rylai\Analyzers;

use phpDocumentor\Reflection\DocBlockFactory;
use Rylai\Reflection\File;

class Document implements AnalyzerInterface
{

    protected $_factory;

    public function __construct()
    {
        $this->_factory = DocBlockFactory::createInstance();
    }

    public function analyze(File $file)
    {
        $report             = new \stdClass;
        $report->namespaces = [];
        $report->file       = $file->getName();

        $namespaces = $file->getReflection()->getFileNamespaces();

        foreach ($namespaces as $namespace) {
            $report->namespaces[] = $this->_analyzeNamespace($namespace);
        }

        return $report;
    }

    protected function _analyzeNamespace($namespace)
    {
        $report = $this->_analyze($namespace);

        $report->classes = [];
        foreach ($namespace->getClasses() as $class) {
            $report->classes[] = $this->_analyzeClass($class);
        }

        return $report;
    }

    protected function _analyzeClass($class)
    {
        $report = $this->_analyze($class);

        $report->constants  = [];
        $report->properties = [];
        $report->methods    = [];

        foreach ($class->getConstants() as $constant => $value) {
            $report->constants[] = [
                "name"  => $constant,
                "value" => $value,
                "type"  => gettype($value),
            ];
        }

        foreach ($class->getProperties() as $property) {
            $report->properties[] = $this->_analyze($property, function ($report, $docblock) {
                $report->variables = [];
                foreach ($docblock->getTagsByName("var") as $tag) {
                    $report->variables[] = [
                        "name"        => $tag->getName(),
                        "type"        => (string) $tag->getType(),
                        "description" => (string) $tag->getDescription(),
                    ];
                }
            });
        }

        foreach ($class->getMethods() as $method) {
            $report->methods[] = $this->_analyze($method, function ($report, $docblock) {
                $report->params = [];
                foreach ($docblock->getTagsByName("param") as $tag) {
                    $report->params[] = [
                        "name"        => $tag->getName(),
                        "type"        => (string) $tag->getType(),
                        "description" => (string) $tag->getDescription(),
                    ];
                }

                foreach ($docblock->getTagsByName("return") as $tag) {
                    $report->return = [
                        "type"        => (string) $tag->getType(),
                        "description" => (string) $tag->getDescription(),
                    ];
                }
            });
        }

        return $report;
    }

    protected function _analyze($target, $reader = null)
    {
        $doccomment = $target->getDocComment() ?: "/** */";
        $docblock   = $this->_factory->create($doccomment);
        $report     = new \stdClass;

        $report->summary     = $docblock->getSummary();
        $report->description = (string) $docblock->getDescription();
        $report->name        = $target->getName();

        if (is_callable($reader)) {
            $reader($report, $docblock);
        }

        return $report;
    }
}
