<?php

namespace Yak\System\Extractor;

use Yak\System\Extractor;
use YakRouteIntent;
use Yak\System\Context;

class RouteIntentControllerExtractor extends Extractor
{
	public static function extract(...$arguments)
	{
		return self::do(...$arguments);
	}

	private static function do(YakRouteIntent $intent)
	{
		return Context::getApplication()->getNamespace() . '\\Controller\\' . $intent->getController();
	}
}