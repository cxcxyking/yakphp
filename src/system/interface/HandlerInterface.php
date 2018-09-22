<?php

namespace Yak\System;

interface HandlerInterface
{
	static function handle(...$arguments): int;
}