<?php

namespace Yak\System\Extractor;

use Yak\System\Extractor;
use YakRouteIntent;

class RouteIntentViewExtractor extends Extractor
{
	public static function extract(...$arguments)
	{
		return self::do(...$arguments);
	}

	private static function do(YakRouteIntent $intent)
	{
		return $intent->getView();
	}
}