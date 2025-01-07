<?php

namespace App\Manager;

use App\Exception\InvalidArgumentException;

class ProgramInstructionManager extends AbstractSolutionManager {
	public function formatInput(string $fileContent): array {
		return explode("\n", $fileContent);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function execute(array $instructionLines, bool $withDoAndDoNot = false): int{
		$result = [];
		$availableInstructionsRegex = '/(mul\(\d{1,}\,\d{1,}\))|(do\(\))|(don\'t\(\))/';
		$isActive = true;

		foreach($instructionLines as $line) {
			$valid = preg_match_all($availableInstructionsRegex, $line, $matches);
			if(!$valid) {
				continue;
			}

			$lineResults = $this->executeInstructions($matches[0], $withDoAndDoNot, $isActive);
			$result[] = array_sum($lineResults);
		}
		return array_sum($result);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function executeInstructions(array $instructions, bool $withDoAndDoNot, bool &$isActive): array {
		$result = [];

		foreach($instructions as $instruction) {
			if(str_starts_with($instruction, 'do')) {
				$isActive = true;
			}
			if(str_starts_with($instruction, 'don\'t')) {
				$isActive = false;
			}
			if($withDoAndDoNot && !$isActive) {
				continue;
			}

			if(str_starts_with($instruction, 'mul')) {
				$result[] = $this->executeInstruction($instruction);
			}
		}
		return $result;
	}

	public function executeInstruction(string $instruction): float {
		preg_match_all('/[0-9]{1,}/', $instruction, $inputNumbers);

		$inputNumbers = $inputNumbers[0];
		if(count($inputNumbers) !== 2) {
			throw new InvalidArgumentException($instruction);
		}
		return (float) bcmul((float) $inputNumbers[0], (float) $inputNumbers[1]);
	}
}
