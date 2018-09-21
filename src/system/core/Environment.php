<?php

namespace Yak\System;

final class Environment
{
    private static $mUrlPath = null;
    private static $mClientAddress = null;
    private static $mClientPort = -1;
    private static $mRequestTime = 0;
    private static $mRequestMethod = null;

    public static function getUrlPath()
    {
        return self::$mUrlPath ?: self::$mClientAddress = self::_getUrlPath();
    }

    public static function getClientAddress(): string
    {
        return self::$mClientAddress ?: self::$mClientAddress = self::_getClientAddress();
    }

    public static function getClientPort(): int
    {
        return self::$mClientPort ?: self::$mClientPort = self::_getClientPort();
    }

    public static function getRequestTime(): int
    {
        return self::$mRequestTime ?: self::$mRequestTime = self::_getRequestTime();
    }

    public static function getRequestMethod(): string
    {
        return self::$mRequestMethod ?: self::$mRequestMethod = self::_getRequestMethod();
    }

    private static function _getUrlPath()
    {
        if (isset($_SERVER['PATH_INFO'])) {
            return $_SERVER['PATH_INFO'];
        } elseif (isset($_SERVER['REQUEST_URI'])) {
            $u = $_SERVER['REQUEST_URI'];
            if (($i = strpos($u, '?')) !== false) {
                $u = substr($u, 0, $i);
            }
            return preg_replace('/\/+/', '/', substr($u, strlen($_SERVER['SCRIPT_NAME'])));
        } else {
            return preg_replace('/\/+/', '/', substr($_SERVER['PHP_SELF'], strlen($_SERVER['SCRIPT_NAME'])));
        }
    }

    private static function _getClientAddress(): string
    {
        return $_SERVER['X-FORWARDED-FOR'] ?? $_SERVER['REMOTE_ADDR'];
    }

    private static function _getClientPort(): int
    {
        return $_SERVER['X-FORWARDED-PORT'] ?? $_SERVER['REMOTE_PORT'];
    }

    private static function _getRequestTime(): int
    {
        return $_SERVER['REQUEST_TIME'];
    }

    private static function _getRequestMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

}