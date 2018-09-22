<?php

namespace Yak\System\Extractor;

use Yak\System\Extractor;

class RouteModelParameterExtractor extends Extractor
{
	public static function extract($collection)
	{
		return self::do(...$arguments);
	}

	private static function do(array $collection)
	{
		return $collection['action'] ?? '';
	}
}