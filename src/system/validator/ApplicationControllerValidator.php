<?php

namespace Yak\System\Validator;

use Yak\System\Validator;

class ApplicationControllerValidator extends Validator
{
	public static function validate($controller, ...$inputs): bool
	{
		return class_exists($controller, true);
	}
}