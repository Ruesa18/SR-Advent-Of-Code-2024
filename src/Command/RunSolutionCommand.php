<?php

namespace App\Command;

use App\Exception\AdventOfCodeException;
use App\Exception\InvalidArgumentException;
use App\Exception\UnequalCountException;
use App\Exception\UnexpectedTypeException;
use App\Manager\AdventOfCodeManager;
use App\Manager\LocationListManager;
use App\Manager\ProgramInstructionManager;
use App\Manager\ReactorReportManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
	name: 'advent:run:solution',
	description: 'Run solution of given day'
)]
class RunSolutionCommand extends Command {
	public const ARG_DAY = 'day';

	protected function configure(): void {
		$this->addArgument(self::ARG_DAY, InputArgument::REQUIRED, 'The day of the advent challenge');
	}

	/**
	 * @throws UnequalCountException
	 * @throws UnexpectedTypeException
	 * @throws AdventOfCodeException
	 * @throws InvalidArgumentException
	 */
	protected function execute(InputInterface $input, OutputInterface $output): int {
		$day = $input->getArgument(self::ARG_DAY);

		if(!is_numeric($day)) {
			throw new UnexpectedTypeException();
		}
		$day = (int) $day;

		$adventOfCodeManager = new AdventOfCodeManager();
		$input = $adventOfCodeManager->getTaskInputIfExists($day);

		switch($day) {
			case 1:
				$manager = new LocationListManager();
				$arrays = $manager->formatInput($input);
				$locationDistance = $manager->getLocationDistance($arrays['left'], $arrays['right']);
				$output->writeln(sprintf('Part 1: The location distance is %s! 🎄', $locationDistance));

				$locationSimilarityScore = $manager->getLocationSimilarityScore($arrays['left'], $arrays['right']);
				$output->writeln(sprintf('Part 2: The location similarity is %s! 🎄', $locationSimilarityScore));
				break;
			case 2:
				$manager = new ReactorReportManager();
				$reactorReports = $manager->formatInput($input);
				$safeReactorReportCount = $manager->countSafeReactorReports($reactorReports);
				$output->writeln(sprintf('Part 1: The amount of safe reports is %s! 🎄', $safeReactorReportCount));

				break;
			case 3:
				$manager = new ProgramInstructionManager();
				$instructionLines = $manager->formatInput($input);
				$result = $manager->execute($instructionLines);
				$output->writeln(sprintf('Part 1: The result of the instructions is %s! 🎄', $result));

				$resultWithDoAndDont = $manager->execute($instructionLines, true);
				$output->writeln(sprintf('Part 2: The result of the instructions is %s! 🎄', $resultWithDoAndDont));
				break;
			default:
				$output->writeln('This day has not been solved yet 🌲');
		}

		return self::SUCCESS;
	}
}
