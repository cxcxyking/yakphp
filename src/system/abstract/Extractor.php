<?php

namespace Yak\System;

use YakException;
use ReflectionClass;
use ReflectionMethod;
use ReflectionException;

abstract class Extractor
{
	final private function __construct()
	{
	}

	/**
	 * @throws NotImplementedException
	 */
	public static function extract()
	{
		if (self::getExtractors(static::class) === []) {
			throw new NotImplementedException(static::class, Extractor::class);
		}
	}

	private static function getExtractors(string $class)
	{
		try {
			$classRef = new ReflectionClass($class);
			$methodRefs = array_filter(
				$classRef->getMethods(ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_STATIC),
				function (ReflectionMethod $methodRef) {
					return substr($methodRef->getName(), 0, '7') === 'extract';
				}
			);
			return $methodRefs;
		} catch (ReflectionException $e) {
			return [];
		}
	}
}