<?php

namespace App\Exception;

use Throwable;

class InvalidArgumentException extends \Exception {
	public function __construct(mixed $variable, int $code = 0, ?Throwable $previous = null) {
		$message = sprintf('Did not expect %s', $variable);
		parent::__construct($message, $code, $previous);
	}
}
