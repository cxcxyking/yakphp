<?php

namespace Yak\System;

use YakRouteIntent;
use Yak\System\Event\EventGroup;
use Yak\System\Router\PathRouteMatcher;
use Yak\System\Router\QueryRouteMatcher;
use Yak\System\Extractor\RouteIntentControllerExtractor;
use Yak\System\Extractor\RouteIntentActionExtractor;
use Yak\System\Extractor\RouteIntentModelExtractor;
use Yak\System\Extractor\RouteIntentViewExtractor;
use Yak\System\Validator\ApplicationControllerValidator;
use Yak\System\Validator\ApplicationActionValidator;
use Yak\System\Validator\ApplicationModelValidator;
use Yak\System\Validator\ApplicationViewValidator;

final class Router
{
	const EXTRACTOR = 0x00;
	const VALIDATOR = 0x01;
	const LABEL = 0x02;

	private static $httpCodes = [];
	private static $matchers = [
		YAK_PATH_ROUTE => PathRouteMatcher::class,
		YAK_QUERY_ROUTE => QueryRouteMatcher::class
	];
	private static $labels = [
		[
			Router::LABEL => 'controller',
			Router::EXTRACTOR => RouteIntentControllerExtractor::class,
			Router::VALIDATOR => ApplicationControllerValidator::class
		],
		[
			Router::LABEL => 'action',
			Router::EXTRACTOR => RouteIntentActionExtractor::class,
			Router::VALIDATOR => ApplicationActionValidator::class
		],
		[
			Router::LABEL => 'model',
			Router::EXTRACTOR => RouteIntentModelExtractor::class,
			Router::VALIDATOR => ApplicationModelValidator::class
		],
		[
			Router::LABEL => 'view',
			Router::EXTRACTOR => RouteIntentViewExtractor::class,
			Router::VALIDATOR => ApplicationViewValidator::class
		]
	];

	public static function addMatcher(int $type, string $matcher)
	{
		self::$matchers[$type] = $matcher;
	}

	public static function addLabel(string $label, Extractor $extractor, Validator $validator)
	{
		self::$labels[] = [
			Router::LABEL => $label,
			Router::EXTRACTOR => $extractor,
			Router::VALIDATOR => $validator
		];
	}

	public static function init()
	{
		$httpStatusCodes = require YAK_DAT . '/HttpCode.php';
		self::$httpCodes = $httpStatusCodes['1.1'];
	}

	public static function match(array $rules)
	{
		foreach ($rules as $rule) {
			if (isset(self::$matchers[$rule->getType()])) {
				$matcher = self::$matchers[$rule->getType()];
				if (call_user_func([$matcher, 'match'], $rule)) {
					return call_user_func([$matcher, 'parse'], $rule);
				}
			}
		}
		return null;
	}

	public static function fetch(YakRouteIntent $intent, callable $success, callable $failure)
	{
		$properties = [];
		foreach (self::$labels as $label) {
			$value = call_user_func([$label[Router::EXTRACTOR], 'extract'], $intent);
			$valid = call_user_func([$label[Router::VALIDATOR], 'validate'], $value);
			if ($valid) {
				$properties[$label[Router::LABEL]] = $value;
			} else {
				$failure($intent, $label[Router::LABEL]);
				return null;
			}
		}
		return $success($intent, $properties);
	}

	public static function direct(YakRouteIntent $intent)
	{
		$controller = $intent->getTarget()['controller'];
		call_user_func([new $controller($intent), $intent->getTarget()['action']], $intent);
	}

	public static function status(string $code)
	{
		if (isset(self::$httpCodes[$code])) {
			header(self::$httpCodes[$code]);
		}
	}
}