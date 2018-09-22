<?php

namespace Yak\System\Validator;

use Yak\System\Validator;

class ApplicationActionValidator extends Validator
{
	public static function validate($action): bool
	{
		return class_exists($action[0], true) && method_exists($action[0], $action[1]);
	}
}