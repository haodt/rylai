<?php

namespace Rylai\Runner;

use Rylai\Analyzers\AnalyzerInterface;
use Rylai\Reflection\File;
use Rylai\Repository;
use Rylai\Stores\StoreInterface;
use Symfony\Component\Finder\Finder;

/**
 * Runner abstraction
 *
 * Scan the folder , run analyzer , store the report
 */
abstract class AbstractRunner implements RunnerInterface
{
    /**
     * Repositories to store reflections by name
     *
     * For example we might want directory A to have different stores . Generally we only need 1 repo but this allow easy change later in future
     * @var Repository[]
     */
    protected $_repositories = [];

    /**
     * Get target path
     * @return string[]
     */
    abstract public function getPaths();

    /**
     * Get analyzers
     * @return AnalyzerInterface[]
     */
    abstract public function getAnalyzers();

    /**
     * Get stores
     * @return StoreInterface[]
     */
    abstract public function getStores();

    /**
     * Get all repositories
     * @return Repository[]
     */
    public function getRepositories()
    {
        return $this->_repositories;
    }

    /**
     * Runner will perform analyzing and storing the results
     *
     * After run, we will have reflections grouped by path key ( 'rylai' => 'var/www/rylai' ) . Then we will have all reflections analyzed and generated reports . After that we will fire up stores to store the reports
     * @return void
     */
    public function run()
    {

        foreach ($this->getPaths() as $key => $path) {

            $repository = new Repository($key);
            foreach ($this->getAnalyzers() as $analyzer) {
                $repository->addAnalyzer($analyzer);
            }

            $finder = new Finder;
            $finder->files()->in($path);

            foreach ($finder as $file) {
                $repository->add(new File($file->getRealPath(), $path));
            }

            $this->_repositories[] = $repository;

        }

        foreach ($this->_repositories as $repository) {
            foreach ($this->getStores() as $store) {
                $store->store($repository);
            }
        }
    }

}
