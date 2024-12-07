<?php

namespace App\Manager;

abstract class AbstractSolutionManager {
	public abstract function formatInput(string $fileContent): mixed;
}
