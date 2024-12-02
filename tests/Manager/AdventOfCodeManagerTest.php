<?php

namespace App\Tests\Manager;

use App\Manager\AdventOfCodeManager;
use App\Tests\AbstractSnapshotTest;

class AdventOfCodeManagerTest extends AbstractSnapshotTest {
	public function testInstructions(): void {
		$adventOfCodeManager = new AdventOfCodeManager();

		$html = file_get_contents(__DIR__.'/../Resources/instruction_1.html');
		$instructionHtml = $adventOfCodeManager->retrieveInstructionsPart($html);

		$this->assertNotEmpty($instructionHtml);
		$this->assertSnapshot('instruction_1.html', $instructionHtml);

		$this->saveSnapshot('instruction_1.html', $instructionHtml);
	}
}
