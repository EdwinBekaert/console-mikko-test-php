<?php
declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExampleCommand extends Command
{

    public function __construct()
    {
        parent::__construct();

    }

    protected function configure()
    {
        $this->setName('app:example')
            ->setDescription('Example command')
            ->setHelp('This is an example command');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('This is an example, replace or edit me');
    }
}

