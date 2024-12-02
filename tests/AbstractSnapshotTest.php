<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class AbstractSnapshotTest extends KernelTestCase {
	private string $snapshotDirectory = __DIR__.'/../var/snapshot';

	public function saveSnapshot(string $filename, string $content): void {
		if(!is_dir($this->snapshotDirectory) && !mkdir($this->snapshotDirectory) && !is_dir($this->snapshotDirectory)) {
			throw new \RuntimeException(sprintf('Directory "%s" was not created', $this->snapshotDirectory));
		}
		file_put_contents(sprintf('%s/%s', $this->snapshotDirectory, $filename), trim($content));
	}

	public function assertSnapshot(string $filename, string $content): void {
		$snapshot = file_get_contents(sprintf('%s/%s', $this->snapshotDirectory, $filename));
		$this->assertEquals($snapshot, trim($content));
	}
}
