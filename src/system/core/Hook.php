<?php

namespace Yak\System;

if (!defined('YAK')) {
	die(TEXT_NO_PERMISSION_TO_ACCESS);
}

final class Hook
{
	private static $mTags = [];
	private static $mMeta = [];
	private static $mCallbacks = [];

	public static function register(string $tag, callable $callback)
	{
		if (!isset(self::$mTags[$tag])) {
			self::$mTags[$tag] = [];
		}
		do {
			$id = self::createCallbackId();
		} while (isset(self::$mCallbacks[$id]));
		self::$mCallbacks[$id] = $callback;
		self::$mMeta[$id] = ['tag' => $tag];
		self::$mTags[$tag][] = $id;
	}

	public static function unregister(string $tag)
	{
		if (isset(self::$mTags[$tag])) {
			foreach (self::$mTags[$tag] as $id) {
				self::delete($id);
			}
			unset(self::$mTags[$tag]);
		}
	}

	public static function trigger(string $tag, array $arguments = [])
	{
		if (isset(self::$mTags[$tag])) {
			foreach (self::$mTags[$tag] as $id) {
				call_user_func(self::$mCallbacks[$id], $id, ...$arguments);
			}
		}
	}

	public static function delete(string $id)
	{
		if (isset(self::$mCallbacks[$id])) {
			$tag = self::$mMeta[$id]['tag'];
			$index = array_search($id, self::$mTags[$tag], true);
			unset(self::$mTags[$tag][$index]);
			unset(self::$mCallbacks[$id]);
			unset(self::$mMeta[$id]);
		}
	}

	private static function createCallbackId(): string
	{
		return uniqid('', true);
	}
}