<?php

namespace Rylai\Tests;

use PHPUnit\Framework\TestCase;
use Rylai\Reflection\File;
use Rylai\Repository;
use Rylai\Stores\Local;
use Rylai\Tests\Runners\Rylai;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Local store testing
 */
class LocalTest extends TestCase
{
    /**
     * Store for testing
     * @var Local
     */
    protected $_store;

    /**
     * Test repository
     * @var Repository
     */
    protected $_repository;

    /**
     * Setup runner
     * @return void
     */
    public function setUp()
    {
        $root              = __DIR__ . "/../../fixtures/";
        $this->_repository = new Repository("rylai");
        $this->_store      = new Local([
            "store" => __DIR__ . "/docs",
            "views" => __DIR__ . "/views",
        ]);

        $this->_repository
            ->add(new File($root . "CrystalNova.php", $root))
            ->add(new File($root . "Items/Courier.php", $root));

        $this->_store->store($this->_repository);
    }

    /**
     * Teardown the store
     *
     * Clean up folders inside docs so we wont commit it into sourcode
     * @return void
     */
    public function tearDown()
    {
        $this->_store      = null;
        $this->_repository = null;

        $path       = __DIR__ . "/docs/rylai";
        $filesystem = new Filesystem;
        $finder     = new Finder();

        $finder->files()->in($path);
        $filesystem->remove($finder);
        $filesystem->remove([$path]);
    }

    public function testStore()
    {
        /**
         * Test folder clean up and permission
         */
        $path = __DIR__ . "/docs/rylai";

        $this->assertTrue(file_exists($path));
        $this->assertTrue(is_dir($path));
        $this->assertTrue(is_writable($path));
        /**
         * Test folder
         */
        $finder = new Finder();
        $finder->files()->in($path);

        $maps = [];
        foreach ($finder as $file) {
            $maps[] = str_replace(".php", ".html", str_replace("/", "_", $file->getRelativePathname()));
        }

        $this->assertEquals([
            "CrystalNova.html",
            "Items_Courier.html",
        ], $maps);
    }

    public function testContents()
    {
        $root = __DIR__ . "/../../fixtures/";
        $path = __DIR__ . "/docs/rylai";

        $view = new \Twig_Environment(new \Twig_Loader_Filesystem(__DIR__ . "/views"));
        $view->addGlobal("repository", $this->_repository);

        $finder = new Finder();
        $finder->files()->in($path);

        $maps = array_map(function ($file) use ($view) {
            return $view->render("file.twig", [
                "file"    => $file,
                "reports" => $this->_repository->analyze($file),
            ]);
        }, $this->_repository->getFiles());

        $key = 0;
        foreach ($finder as $file) {
            $this->assertEquals($maps[$key], $file->getContents());
            $key++;
        }

        $this->assertEquals($key, 2);

    }

}
