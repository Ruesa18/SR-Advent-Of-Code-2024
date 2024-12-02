<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'advent:test',
    description: 'Command for testing purposes'
)]
class TestCommand extends Command {
    protected function execute(InputInterface $input, OutputInterface $output): int {
        $output->writeln('Hello from the test command');
        return Command::SUCCESS;
    }
}