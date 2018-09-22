<?php

namespace Yak\System\Extractor;

use YakRouteTarget;
use Yak\System\Extractor;

class RouteTargetExtractor extends Extractor
{
	public static function extractController(YakRouteTarget $target)
	{
		return $target->getController();
	}

	public static function extractAction(YakRouteTarget $target)
	{
		return $target->getAction();
	}

	public static function extractModel(YakRouteTarget $target)
	{
		return $target->getModel();
	}

	public static function extractView(YakRouteTarget $target)
	{
		return $target->getView();
	}
}