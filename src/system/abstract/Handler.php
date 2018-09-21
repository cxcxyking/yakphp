<?php

namespace Yak\System;

abstract class Handler implements HandlerInterface
{
	private static $cache = [];

	final private function __construct()
	{
	}

	final public static function get(string $handler)
	{
		if (get_parent_class($handler) === Handler::class) {
			return call_user_func([$handler, 'new']);
		} else {
			return null;
		}
	}

	final public static function new()
	{
		if (static::class === Handler::class) {
			return null;
		}
		if (!isset(self::$cache[static::class])) {
			self::$cache[static::class] = new static();
		}
		return self::$cache[static::class];
	}
}