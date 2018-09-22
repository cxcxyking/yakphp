<?php

class YakException extends Exception
{
	static private $exceptions = [];

	public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
	{
		if (!isset(self::$exceptions[static::class])) {
			self::$exceptions[static::class] = ['id' => static::getExceptionId()];
		}
		parent::__construct($message, $code, $previous);
	}

	final public static function getExceptionId()
	{
		if (isset(self::$exceptions[static::class])) {
			return self::$exceptions[static::class]['id'];
		}
	}
}