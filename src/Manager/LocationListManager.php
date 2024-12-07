<?php

namespace App\Manager;

use App\Exception\UnequalCountException;

class LocationListManager extends AbstractSolutionManager {
	/**
	 * @throws UnequalCountException
	 */
	public function getLocationDistance(array $leftList, array $rightList): int {
		sort($leftList);
		sort($rightList);

		if(count($leftList) !== count($rightList)) {
			throw new UnequalCountException();
		}

		$distances = [];
		foreach ($leftList as $index => $leftLocation) {
			$distances[] = $leftLocation > $rightList[$index] ? $leftLocation - $rightList[$index] : $rightList[$index] - $leftLocation;
		}
		return array_sum($distances);
	}

	public function getLocationSimilarityScore(array $leftList, array $rightList): int {
		$similarityScore = 0;
		foreach($leftList as $leftLocation) {
			$locationCount = 0;

			foreach($rightList as $rightLocation) {
				if($leftLocation === $rightLocation) {
					$locationCount++;
				}
			}
			$similarityScore += $locationCount * $leftLocation;
		}
		return $similarityScore;
	}

	public function formatInput($fileContent): array {
		$leftList = [];
		$rightList = [];
		$array = explode("\n", $fileContent);
		foreach($array as $line) {
			$line = explode('   ', $line);
			$leftList[] = $line[0];
			$rightList[] = $line[1];
		}
		return ['left' => $leftList, 'right' => $rightList];
	}
}
