<?php

namespace Yak\System;

use YakApplication;

final class Context
{
	/**
	 * @var Context
	 */
	private static $mContext = null;

	/**
	 * @var YakApplication
	 */
	private $mApp = null;

	public function __construct(YakApplication $app)
	{
		$this->mApp = $app;
	}

	public static function setContext(Context $context)
	{
		self::$mContext = $context;
	}

	public static function getContext(): Context
	{
		return self::$mContext;
	}

	public static function getApplication(): YakApplication
	{
		return self::$mContext->mApp;
	}
}