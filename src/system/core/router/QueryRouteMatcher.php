<?php

namespace Yak\System\Router;

use Yak\System\Context;
use YakRouteRule;
use YakRouteTarget;
use YakRouteIntent;
use Yak\System\RouteMatcherInterface;
use Yak\System\Input;

class QueryRouteMatcher implements RouteMatcherInterface
{
	public static function match(YakRouteRule $rule): bool
	{
		if ($rule->getType() === YAK_QUERY_ROUTE) {
			$meta = explode('&', $rule->getRule());
			for ($i = 0; $i < count($meta); $i++) {
				if (Input::getHttpRequestField(explode('=', $meta[$i])[0]) === null) {
					return false;
				}
			}
			return true;
		} else {
			return false;
		}
	}

	public static function parse(YakRouteRule $rule): YakRouteIntent
	{
		$reg = [];
		$meta = explode('&', $rule->getRule());
		for ($i = 0; $i < count($meta); $i++) {
			$pair = explode('=', $meta[$i]);
			$reg[substr($pair[1], 1, -1)] = Input::getHttpRequestField($pair[0]);
		}
		return new YakRouteIntent(Context::getApplication(), new YakRouteTarget($reg['controller'] ?? '', $reg['action'] ?? '', $reg['model'] ?? '', $reg['view'] ?? ''), $reg);
	}
}