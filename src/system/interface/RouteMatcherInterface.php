<?php

namespace Yak\System;

use YakRouteRule;
use YakRouteIntent;

interface RouteMatcherInterface
{
	static function match(YakRouteRule $rule): bool;

	static function parse(YakRouteRule $rule): YakRouteIntent;
}