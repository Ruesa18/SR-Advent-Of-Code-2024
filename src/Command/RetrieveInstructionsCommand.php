<?php

namespace App\Command;

use App\Exception\AdventOfCodeException;
use App\Manager\AdventOfCodeManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
	name: 'advent:get:instructions',
	description: 'Retrieve instructions from a URL'
)]
class RetrieveInstructionsCommand extends Command {
	public const ARG_URL = 'url';

	protected function configure(): void {
		$this->addArgument(self::ARG_URL, InputArgument::REQUIRED, 'The URL to retrieve instructions from');
	}

	protected function execute(InputInterface $input, OutputInterface $output): int {
        $url = $input->getArgument(self::ARG_URL);
		$adventOfCodeManager = new AdventOfCodeManager();

        if(!$url) {
            $output->writeln('Please provide a URL');
            return Command::FAILURE;
        }

		try {
			$instructions = $adventOfCodeManager->getInstructionsFromUrl($url);
			$urlParts = explode('/', $url);
			$instructionsNumber = array_pop($urlParts);

			if(!$instructionsNumber || !is_numeric($instructionsNumber)) {
				$output->writeln('Could not determine instructions number from URL');
				return Command::FAILURE;
			}

			$adventOfCodeManager->saveInstructions($instructions, (int) $instructionsNumber);

        	return Command::SUCCESS;
		}catch(AdventOfCodeException $exception) {
			$output->writeln(sprintf('<error>%s</error>', $exception->getMessage()));
			$output->writeln('');
			$output->writeln(sprintf('<comment>%s</comment>', $exception->getTraceAsString()));
			return Command::FAILURE;
		}
    }
}
