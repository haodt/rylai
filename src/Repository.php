<?php

namespace Rylai;

use Rylai\Analyzers\AnalyzerInterface;
use Rylai\Reflection\File;

/**
 * Storing reflections inside an repository for later store can grouped it easily
 *
 * For example having 2 repos going to 2 different indexs of elastic search or having 2 different folders for local html
 */
class Repository
{

    /**
     * File reflection
     * @var File[]
     */
    protected $_files = [];

    /**
     * Analyzers
     * @var AnalyzerInterface[]
     */
    protected $_analyzers = [];

    /**
     * Unique name between repos
     * @var string
     */
    protected $_name;

    public function __construct($name)
    {
        $this->_name = $name;
    }

    /**
     * Get repo name
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Get all files added
     * @return File[]
     */
    public function getFiles()
    {
        return $this->_files;
    }

    /**
     * Add new analyzer
     * @param AnalyzerInterface $analyzer
     */
    public function addAnalyzer(AnalyzerInterface $analyzer)
    {
        $this->_analyzers[] = $analyzer;
    }

    /**
     * Get all reports for current file
     *
     * Store will store by file, so we analyze by file inside repository
     * @param  File   $file
     * @return array
     */
    public function analyze(File $file)
    {
        $reports = [];
        foreach ($this->_analyzers as $analyzer) {
            $reports[$analyzer->getName()] = $analyzer->analyze($file);
        }
        return $reports;
    }

    /**
     * Add new reflection
     * @param File $file
     * @return Repository
     */
    public function add(File $file)
    {
        $this->_files[] = $file;
        return $this;
    }
}
