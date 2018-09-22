<?php

namespace Yak\System;

final class Event
{

	/**
	 * @var Event\EventGroup
	 */
	private static $defaultEventGroup = null;

	public static function init()
	{
		self::$defaultEventGroup = new Event\EventGroup();
	}

	public static function on(string $name, callable $callback)
	{
		self::$defaultEventGroup->on($name, new Event\EventUnit($callback));
	}

	public static function off(string $name)
	{
		self::$defaultEventGroup->off($name);
	}

	public static function emit(string $name, array $arguments = [])
	{
		self::$defaultEventGroup->emit($name, $arguments);
	}
}