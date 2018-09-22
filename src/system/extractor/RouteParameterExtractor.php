<?php

namespace Yak\System\Extractor;

use Yak\System\Extractor;

class RouteParameterExtractor extends Extractor
{
	public static function extractController(array $collection)
	{
		return $collection['controller'];
	}

	public static function extractAction(array $collection)
	{
		return $collection['action'];
	}

	public static function extractModel(array $collection)
	{
		return $collection['model'];
	}

	public static function extractView(array $collection)
	{
		return $collection['view'];
	}
}