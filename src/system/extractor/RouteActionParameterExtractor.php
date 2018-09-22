<?php

namespace Yak\System\Extractor;

use Yak\System\Extractor;

class RouteActionParameterExtractor extends Extractor
{
	public static function extract(\YakRouteTarget $target)
	{
		return $target->getAction();
	}
}