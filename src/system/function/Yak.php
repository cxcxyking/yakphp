<?php

namespace Yak\System;

use YakApplication;

function IsImplemented($interface, $class)
{
	return in_array($interface, class_implements($class));
}

function Handle(string $handler, ...$arguments)
{
	static $cache = [];
	if (!isset($cache[$handler])) {
		if (class_exists($handler) && IsImplemented(HandlerInterface::class, $handler)) {
			if (get_parent_class($handler) === Handler::class) {
				$cache[$handler] = Handler::get($handler);
			} else {
				$cache[$handler] = new $handler;
			}
		} else {
			return;
		}
	}
	call_user_func_array([$cache[$handler], 'handle'], $arguments);
}

function DefaultRouteEnabled(YakApplication $app)
{
	return $app->getSettings('route.default.controller') && $app->getSettings('route.default.action') && $app->getSettings('route.default.model') && $app->getSettings('route.default.view');
}

function 

function yak_initialize(string $class, array $arguments = [])
{
	static $marker = [];

	if (!method_exists($class, 'init')) {
		return;
	}

	if (in_array($class, $marker)) {
		return;
	}

	$marker[] = $class;
	call_user_func_array([$class, 'init'], $arguments);
}