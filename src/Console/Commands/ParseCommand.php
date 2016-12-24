<?php

namespace Rylai\Console\Commands;

use Rylai\Analyzers\Document;
use Rylai\Reflection\Directory;
use Rylai\Stores\Local;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
                "import",
                InputArgument::REQUIRED,
                "Absolute path to directory you want to parse"
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $import = $input->getArgument("import");

        $directory = new Directory($import, [
            "analyzers" => [
                new Document,
            ],
            "store"     => new Local,
        ]);
    }
}
