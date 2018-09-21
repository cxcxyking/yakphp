<?php

namespace Yak\System\Router;

use YakRouteRule;
use Yak\System\RouteMatcherInterface;
use Yak\System\Environment;

class PathRouteMatcher implements RouteMatcherInterface
{
	public static function match(YakRouteRule $rule): bool
	{
		if ($rule->getType() === YAK_PATH_ROUTE) {
			$p = explode('/', Environment::getUrlPath());
			$pp = explode('/', $rule->getRule());
			if (count($p) === count($pp)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public static function parse(YakRouteRule $rule): array
	{
		$p = explode('/', Environment::getUrlPath());
		$pp = explode('/', $rule->getRule());
		$reg = [];
		for ($i = 0; $i < count($pp); $i++) {
			$reg[substr($pp[$i], 1, -1)] = $p[$i];
		}
		return $reg;
	}
}