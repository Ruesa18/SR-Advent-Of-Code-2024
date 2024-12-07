<?php

namespace App\Tests\Manager;

use App\Exception\UnequalCountException;
use App\Manager\LocationListManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LocationListManagerTest extends KernelTestCase {
	/**
	 * @throws UnequalCountException
	 */
	public function testGetLocationDistances(): void {
		$locationListManager = new LocationListManager();

		$leftList = [3, 4, 2, 1, 3, 3];
		$rightList = [4, 3, 5, 3, 9, 3];
		$expectedDistance = 11;

		$actualDistance = $locationListManager->getLocationDistance($leftList, $rightList);

		$this->assertEquals($expectedDistance, $actualDistance);
	}

	public function testGetLocationSimilarityScore(): void {
		$locationListManager = new LocationListManager();

		$leftList = [3, 4, 2, 1, 3, 3];
		$rightList = [4, 3, 5, 3, 9, 3];

		$expectedSimilarityScore = 31;

		$actualSimilarityScore = $locationListManager->getLocationSimilarityScore($leftList, $rightList);

		$this->assertEquals($expectedSimilarityScore, $actualSimilarityScore);
	}
}
