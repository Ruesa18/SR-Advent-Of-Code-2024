<?php

namespace App\Tests\Manager;

use App\Manager\ReactorReportManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ReactorReportManagerTest extends KernelTestCase {
	public function testCountSafeReactorReports(): void {
		$reports = [
			[
				7, 6, 4, 2, 1,
			],
			[
				1, 2, 7, 8, 9,
			],
			[
				9, 7, 6, 2, 1,
			],
			[
				1, 3, 2, 4, 5,
			],
			[
				8, 6, 4, 4, 1,
			],
			[
				1, 3, 6, 7, 9,
			],
		];
		$reactorReportManager = new ReactorReportManager();
		$expectedSafeReactorCount = 2;

		$safeReportsCount = $reactorReportManager->countSafeReactorReports($reports);

		$this->assertEquals($expectedSafeReactorCount, $safeReportsCount);
	}
}
