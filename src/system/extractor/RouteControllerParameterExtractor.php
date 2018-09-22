<?php

namespace Yak\System\Extractor;

use Yak\System\Extractor;

class RouteControllerParameterExtractor extends Extractor
{
	public static function extract(...$arguments)
	{
		return self::do(...$arguments);
	}

	private static function do(array $collection)
	{
		return $collection['action'] ?? '';
	}
}