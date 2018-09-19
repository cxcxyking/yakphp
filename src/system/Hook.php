<?php

namespace Yak\System;

if (!defined('YAK')) {
    die(TEXT_NO_PERMISSION_TO_ACCESS);
}

class Hook
{
    private static $mTags = [];
    private static $mMeta = [];
    private static $mHooks = [];

    public static function register(string $tag, callable $callable)
    {
        if (!isset(self::$mTags[$tag])) {
            self::$mTags[$tag] = [];
        }
        do {
            $id = self::createHookId();
        } while (isset(self::$mHooks[$id]));
        self::$mHooks[$id] = $callable;
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

    public static function trigger(string $tag, array $args = [])
    {
        if (isset(self::$mTags[$tag])) {
            foreach (self::$mTags[$tag] as $id) {
                call_user_func(self::$mHooks[$id], $id, ...$args);
            }
        }
    }

    public static function delete(string $id)
    {
        if (isset(self::$mHooks[$id])) {
            $tag = self::$mMeta[$id]['tag'];
            $index = array_search($id, self::$mTags[$tag], true);
            unset(self::$mTags[$tag][$index]);
            unset(self::$mHooks[$id]);
            unset(self::$mMeta[$id]);
        }
    }

    private static function createHookId(): string
    {
        return uniqid(true);
    }
}