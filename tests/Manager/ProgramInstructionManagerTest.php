<?php

namespace App\Tests\Manager;

use App\Exception\InvalidArgumentException;
use App\Manager\ProgramInstructionManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProgramInstructionManagerTest extends KernelTestCase {
	/**
	 * @throws InvalidArgumentException
	 */
	public function testExecuteMulInstructions(): void {
		$input = 'xmul(2,4)%&mul[3,7]!@^do_not_mul(5,5)+mul(32,64]then(mul(11,8)mul(8,5))';
		$manager = new ProgramInstructionManager();

		$result = $manager->execute([$input]);

		$this->assertEquals(161, $result);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function testExecuteDoAndDoNotInstructions(): void {
		$input = 'xmul(2,4)&mul[3,7]!^don\'t()_mul(5,5)+mul(32,64](mul(11,8)undo()?mul(8,5))';
		$manager = new ProgramInstructionManager();

		$result = $manager->execute([$input], true);

		$this->assertEquals(48, $result);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function testExecuteDoAndDoNotInstructionsCustom(): void {
		$input = 'xmul(1,2)&mul[3,7]!^don\'t()_mul(5,5)+mul(32,64](undo()?mul(1,5)don\'t()mul(1,8)do()mul(1,11))';
		$manager = new ProgramInstructionManager();

		$result = $manager->execute([$input], true);

		$this->assertEquals(18, $result);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function testExecuteDoAndDoNotInstructionsMultiline(): void {
		$inputs = ['xmul(1,2)&mul[3,7]!^don\'t()', '_mul(5,5)+mul(32,64](undo()?mul(1,5)don\'t()mul(1,8)do()mul(1,11))'];
		$manager = new ProgramInstructionManager();

		$result = $manager->execute($inputs, true);

		$this->assertEquals(18, $result);
	}
}
