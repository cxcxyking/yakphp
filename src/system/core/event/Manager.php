<?php

namespace Yak\System\Event;

class Manager
{
	private static $events = [];
	private static $groups = [];

	public static function getEvent(string $id)
	{
		return self::$events[$id] ?? null;
	}

	public static function getGroup(string $id)
	{
		return self::$groups[$id] ?? null;
	}

	public static function registerEvent(Event $event)
	{
		if (!isset(self::$events[$event->getId()])) {
			self::$events[$event->getId()] = $event;
		}
	}

	public static function registerGroup(Group $group)
	{
		if (!isset(self::$groups[$group->getId()])) {
			self::$groups[$group->getId()] = $group;
		}
	}

	public static function unregisterEvent(string $id)
	{
		if (isset(self::$events[$id])) {
			unset(self::$events[$id]);
		}
	}

	public static function unregisterGroup(string $id)
	{
		if (isset(self::$groups[$id])) {
			unset(self::$groups[$id]);
		}
	}
}