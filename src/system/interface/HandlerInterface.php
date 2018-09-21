<?php

namespace Yak\System;

interface HandlerInterface
{
	function handle(...$arguments): int;
}