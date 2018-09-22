<?php

namespace Yak\System;

interface ValidatorInterface
{
	static function validate(...$inputs): bool;
}