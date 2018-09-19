<?php

namespace Yak\System;

class Input
{
    private static $mHttpPost = [];
    private static $mHttpGet = [];
    private static $mHttpRequest = [];
    private static $mHttpCookie = [];

    public static function init()
    {
        self::$mHttpGet = self::httpGetDataFilter($_GET);
        self::$mHttpPost = self::httpPostDataFilter($_POST);
        self::$mHttpRequest = self::httpRequestDataFilter($_REQUEST);
        self::$mHttpCookie = self::httpCookieDataFilter($_COOKIE);
    }

    public static function getHttpGetField(string $name)
    {
        return self::$mHttpGet[$name] ?? null;
    }

    public static function getHttpPostField(string $name)
    {
        return self::$mHttpPost[$name] ?? null;
    }

    public static function getHttpRequestField(string $name)
    {
        return self::$mHttpRequest[$name] ?? null;
    }

    public static function getHttpCookieField(string $name)
    {
        return self::$mHttpCookie[$name] ?? null;
    }

    public static function get(string $name)
    {
        return self::getHttpGetField($name);
    }

    public static function post(string $name)
    {
        return self::getHttpPostField($name);
    }

    public static function request(string $name)
    {
        return self::getHttpRequestField($name);
    }

    public static function cookie(string $name)
    {
        return self::getHttpCookieField($name);
    }

    private static function httpGetDataFilter(array $data): array
    {
        return $data;
    }

    private static function httpPostDataFilter(array $data): array
    {
        return $data;
    }

    private static function httpRequestDataFilter(array $data): array
    {
        return $data;
    }

    private static function httpCookieDataFilter(array $data): array
    {
        return $data;
    }
}