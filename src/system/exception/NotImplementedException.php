<?php

namespace Yak\System;

use YakException;

class NotImplementedException extends YakException
{
	public function __construct(string $class, string $parent)
	{
		parent::__construct($class . ' was not implemented to ' . $parent . '.');
	}
}