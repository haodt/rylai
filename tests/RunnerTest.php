<?php

namespace Rylai\Tests;

use PHPUnit\Framework\TestCase;
use Rylai\Runner\RunnerInterface;
use Rylai\Tests\Runners\Rylai;

/**
 * Use runner to parse fixtures folder and test results
 */
class RunnerTest extends TestCase
{
    /**
     * Runner for testing
     * @var RunnerInterface
     */
    protected $_runner;

    /**
     * Setup runner
     * @return void
     */
    public function setUp()
    {
        $this->_runner = new Rylai;
        $this->_runner->run();
    }

    /**
     * Teardown the runner
     * @return void
     */
    public function tearDown()
    {
        $this->_runner = null;
    }

    public function testPathsAndRepositories()
    {
        $paths        = $this->_runner->getPaths();
        $repositories = $this->_runner->getRepositories();
        /**
         * Test total repository must equal to its path
         */
        $this->assertEquals(count($repositories), count($paths));
        /**
         * Test repository name must be equivalent to it's path key in paths
         */
        foreach ($repositories as $repository) {
            $this->assertTrue(isset($paths[$repository->getName()]));
        }
    }
}
