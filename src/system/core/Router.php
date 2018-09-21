<?php

namespace Yak\System;

use YakRouteIntent;

final class Router
{
	private static $matchers = [];
	private static $httpStatusCode = [];

	public static function setRuleMatcher(int $type, string $matcher)
	{
		self::$matchers[$type] = $matcher;
	}

	public static function init()
	{
		$httpStatusCodes = require YAK_DAT . '/HttpCode.php';
		self::$httpStatusCode = $httpStatusCodes['1.1'];
	}

	/**
	 * @param \YakRouteRule[] $rules
	 * @return null|YakRouteIntent
	 */
	public static function detect(array $rules)
	{
		foreach ($rules as $rule) {
			if ($matcher = self::$matchers[$rule->getType()] ?? null) {
				if (call_user_func([$matcher, 'match'], $rule)) {
					$strategy = call_user_func([$matcher, 'parse'], $rule);
					return new YakRouteIntent($strategy['controller'], $strategy['action'], $strategy['model'], $strategy['view']);
				}
			}
		}
		return null;
	}

	public static function require(YakRouteIntent $intent, array $failCallbacks, array $arguments = [])
	{
		if (($controller = self::validateController($intent->getController())) === '') {
			isset($failCallbacks['onControllerNotFound']) && $failCallbacks['onControllerNotFound']($intent);
			return null;
		}
		if (($action = self::validateAction($controller, $intent->getAction())) === '') {
			isset($failCallbacks['onActionNotFound']) && $failCallbacks['onActionNotFound']($intent);
			return null;
		};
		if (($model = self::validateModel($intent->getModel())) === '') {
			isset($failCallbacks['onModelNotFound']) && $failCallbacks['onModelNotFound']($intent);
			return null;
		}
		if (($view = self::validateView($intent->getView())) === '') {
			isset($failCallbacks['onViewNotFound']) && $failCallbacks['onViewNotFound']($intent);
			return null;
		}
		return new YakRouteIntent($controller, $action, $model, $view, array_merge($intent->getBundle(), $arguments));
	}

	public static function direct(YakRouteIntent $intent)
	{
		$controller = $intent->getController();
		call_user_func([new $controller($intent), $intent->getAction()], $intent);
	}

	public static function status(string $code)
	{
		if (isset(self::$httpStatusCode[$code])) {
			header(self::$httpStatusCode[$code]);
		}
	}

	private static function validateController(string $controller)
	{
		if (is_file($controllerFilePath = Context::getApplication()->getControllerDir() . '/' . $controller . '.php')) {
			require $controllerFilePath;
		} else {
			return '';
		}
		if (class_exists($controllerClass = Context::getApplication()->getNamespace() . '\\Controller\\' . $controller)) {
			return $controllerClass;
		} else {
			return '';
		}
	}

	private static function validateAction(string $controller, string $action)
	{
		if (class_exists($controller) && method_exists($controller, $action)) {
			return $action;
		} else {
			return '';
		}
	}

	private static function validateModel(string $model)
	{
		if (is_file($modelFilePath = Context::getApplication()->getModelDir() . '/' . $model . '.php')) {
			require $modelFilePath;
		} else {
			return '';
		}
		if (class_exists($modelClass = Context::getApplication()->getNamespace() . '\\Model\\' . $model)) {
			return $modelClass;
		} else {
			return '';
		}
	}

	private static function validateView(string $view)
	{
		if (is_file($viewFilePath = Context::getApplication()->getViewDir() . '/' . $view . '.html')) {
			return $view;
		} else {
			return '';
		}
	}
}

Router::setRuleMatcher(YAK_PATH_ROUTE, Router\PathRouteMatcher::class);
Router::setRuleMatcher(YAK_QUERY_ROUTE, Router\QueryRouteMatcher::class);