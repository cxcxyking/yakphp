<?php

namespace Yak\System\Validator;

use Yak\System\Validator;

class ApplicationModelValidator extends Validator
{
	public static function validate($model): bool
	{
		return class_exists($model, true);
	}
}