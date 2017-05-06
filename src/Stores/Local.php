<?php

namespace Rylai\Stores;

use Rylai\Reflection\File;
use Rylai\Repository;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Local exporter to html folder
 */
class Local implements StoreInterface
{

    /**
     * Options
     * @var array
     */
    protected $_options;

    /**
     * View engine
     * @var Twig_Environment
     */
    protected $_view;

    public function __construct(array $options)
    {
        $resolver = new OptionsResolver;
        $resolver->setRequired([
            "store",
            "views",
        ]);
        $resolver->setAllowedValues("store", function ($value) {
            return is_dir($value) && file_exists($value) && is_writable($value);
        });

        $this->_options = $resolver->resolve($options);
        $this->_views   = new \Twig_Environment(new \Twig_Loader_Filesystem($options["views"]));
    }

    /**
     * Storing repo into folder
     *
     * Create repo's name folder inside target directory. Do cleanup before storing as well. Create hierachical folder tree to store file based on its name
     * @param  Repository $repo
     * @param  AnalyzerInterface[] $analyzers
     * @return void
     */
    public function store(Repository $repo)
    {
        $filesystem = new Filesystem;
        $path       = $this->_options["store"] . "/" . $repo->getName();

        if ($filesystem->exists($path)) {
            $finder = new Finder();
            $finder->files()->in($path);

            $filesystem->remove($finder);
            $filesystem->remove([$path]);
        }

        $filesystem->mkdir($path);

        $this->_views->addGlobal("repository", $repo);
        $this->_views->addFilter(new \Twig_Filter("link_to", function ($value) use ($repo) {
            $name = $repo->getName();
            if (preg_match("/^" . $name . "/", $value)) {
                return str_replace("\\", "_", str_replace("$name\\", "", $value)) . ".html";
            }
            return "#";
        }));
        $this->_views->addFilter(new \Twig_Filter("to_string", function ($value) {
            if (is_bool($value)) {
                return ($value) ? "true" : "false";
            }
            return (string) $value;
        }));

        foreach ($repo->getFiles() as $file) {
            $this->_store($path, $file, $repo->analyze($file));
        }
    }

    /**
     * Write file to disk
     *
     * We store all files as flat map Items_Courier,Item_Test,Skill,Skill_Test v.v.. . This will make assets linking easier in views. Link to other file also easier , with few custom page - all in same level so we dont have to do any paths finding in frontend views
     *
     * @param  string $path Root path to store html
     * @param  File   $file
     * @return boolean
     */
    protected function _store($path, File $file, array $reports = [])
    {
        $filesystem = new Filesystem;
        $filename   = str_replace(".php", ".html", $path . "/" . str_replace("/", "_", $file->getName()));

        $filesystem->dumpFile($filename, $this->_render($file, $reports));
    }

    /**
     * Render file
     * @param  File   $file
     * @param  array  $reports Reports by analyzers namespaced by analyzer name eg : ["docblock" => [...]]
     * @return string
     */
    protected function _render(File $file, array $reports)
    {
        return $this->_views->render("file.twig", [
            "file"    => $file,
            "reports" => $reports,
        ]);
    }
}
