<?php

namespace Yak\System\Validator;

use Yak\System\Validator;
use Yak\System\Context;

class ApplicationViewValidator extends Validator
{
	public static function validate($view): bool
	{
		if (is_file(Context::getApplication()->getViewDir() . '/' . $view . '.html')) {
			return true;
		} else {
			return false;
		}
	}
}