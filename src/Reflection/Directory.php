<?php

namespace Rylai\Reflection;

use Symfony\Component\Finder\Finder;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Directory
{
    protected $_options;

    public function __construct($path, array $options)
    {
        $this->_finder = new Finder;
        $this->_finder->files()->in($path);

        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            "analyzers" => [],
            "store"     => null,
        ]);

        $this->_options = $resolver->resolve($options);

        $store = $this->_options["store"];

        foreach ($this->_finder as $file) {
            $reflection = new File($file->getRealPath(), $path);
            foreach ($options["analyzers"] as $analyzer) {
                $report = $analyzer->analyze($reflection);
                if ($store) {
                    $store->store($report);
                }
            }
        }
    }
}
