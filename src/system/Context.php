<?php

namespace Yak\System;

final class Context
{
    /**
     * @var Context
     */
    private static $mContext = null;

    /**
     * @var Application
     */
    private $mApp = null;

    public static function setContext(Context $context)
    {
        self::$mContext = $context;
    }

    public static function getContext(): Context
    {
        return self::$mContext;
    }

    public static function getApplication(): Application
    {
        return self::$mContext->mApp;
    }

    public function __construct(Application $app)
    {
        $this->mApp = $app;
    }
}