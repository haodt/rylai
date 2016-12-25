<?php

namespace Rylai\Console\Commands;

use Rylai\Analyzers\Document;
use Rylai\Reflection\Directory;
use Rylai\Stores\Elasticsearch;
use Rylai\Stores\Local;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class ParseCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName("parse")
            ->setDescription("Parse a file or directory")
            ->setHelp(<<<EOF
The <info>%command.name%</info> command parses a project and generates a <info>JSON</info> formated :
EOF
            );

        $this
            ->addArgument(
                "configs",
                InputArgument::REQUIRED,
                "Absolute path to configuration file"
            )
            ->addArgument(
                "path",
                InputArgument::REQUIRED,
                "Absolute path to folder you want to parse and generate docs"
            )
            ->addArgument(
                "store",
                InputArgument::REQUIRED,
                "Store type [local|api] or you can defined your own"
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configs = $input->getArgument("configs");
        $path    = $input->getArgument("path");
        $store   = $input->getArgument("store");

        if (!file_exists($configs)) {
            throw new \Exception("Configuration path must be readable [$configs] is not exists or not readable");
        }
        $configs = Yaml::parse(file_get_contents($configs));

        switch ($store) {
            case "local":
                $store = new Local($path . $configs["store"]["path"]);
                break;
            case "api":
                $store = new Elasticsearch($configs["store"]);
                break;
            default:
                throw new \Exception("Store [$store] is not supported , please provide your own");
        }

        $directory = new Directory($path, [
            "analyzers" => [
                new Document,
            ],
            "store"     => $store,
        ]);
    }
}
