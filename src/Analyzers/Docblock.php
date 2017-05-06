<?php

namespace Rylai\Analyzers;

use phpDocumentor\Reflection\DocBlockFactory;
use Rylai\Analyzers\Docblock\ReportFile;
use Rylai\Reflection\File;

/**
 * Docblock analyzer
 *
 * Parse dockblock of php file and generate a report of it
 */
class Docblock implements AnalyzerInterface
{

    /**
     * Docblock factory
     * @var DocBlockFactory
     */
    protected $_factory;

    public function __construct()
    {
        $this->_factory = DocBlockFactory::createInstance();
    }

    /**
     * Analyzer name
     *
     * Identify analyzer inside repository
     * @return string
     */
    public function getName()
    {
        return "docblock";
    }

    /**
     * File for analyzing
     *
     * Loop through all properties methods etc and analyze the docblock
     * @param  File   $file
     * @return ReportFile
     */
    public function analyze(File $file)
    {

        $report = new ReportFile();
        $report->parse($file->getReflection(), $this->_factory);
        $report->name = $file->getName();

        return $report;
    }
}
