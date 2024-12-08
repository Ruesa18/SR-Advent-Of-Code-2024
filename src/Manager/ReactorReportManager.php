<?php

namespace App\Manager;

class ReactorReportManager extends AbstractSolutionManager {
	public function formatInput(string $fileContent): array {
		$reactorReports  = [];
		$lines = explode("\n", $fileContent);
		foreach($lines as $line) {
			$reactorReport = explode(' ', $line);
			$reactorReports[] = array_map(fn($item) => (int) $item, $reactorReport);
		}
		return $reactorReports;
	}

	/**
	 * Counts the amount of safe reports in an array.
	 *
	 * @param array<array<int>> $reports
	 * @return int
	 */
	public function countSafeReactorReports(array $reports): int {
		$safeReportCount = 0;
		foreach($reports as $report) {
			if($this->isSafeReport($report, 3)) {
				$safeReportCount++;
			}
		}
		return $safeReportCount;
	}

	/**
	 * Checks if the given report is safe based on the set allowedThreshold.
	 *
	 * @param array<int> $report
	 * @param int $allowedThreshold
	 * @return bool
	 */
	public function isSafeReport(array $report, int $allowedThreshold): bool {
		$lastValue = null;
		$lastIncreasing = null;
		foreach($report as $reportValue) {
			if(!$lastValue) {
				$lastValue = $reportValue;
				continue;
			}

			if($lastValue === $reportValue) {
				return false;
			}

			$currentIncreasing = $lastValue < $reportValue;
			$difference = $lastValue > $reportValue ? $lastValue - $reportValue : $reportValue - $lastValue;

			if($difference > $allowedThreshold) {
				return false;
			}

			if(!is_null($lastIncreasing) && $lastIncreasing !== $currentIncreasing) {
				return false;
			}

			$lastIncreasing = $currentIncreasing;
			$lastValue = $reportValue;
		}

		return true;
	}
}
