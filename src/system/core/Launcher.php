<?php

namespace Yak\System;

use YakRouteIntent;
use YakApplication;

final class Launcher
{
	public static function launchApplication(YakApplication $app)
	{
		Hook::trigger('Yak.Launcher.launchApplication.before');
		self::initSystem();

		self::initApplication($app);
		self::startApplication($app);
		self::destroyApplication($app);
		Hook::trigger('Yak.Launcher.launchApplication.after');
	}

	public static function launchApplicationWithIntent(YakApplication $app, YakRouteIntent $intent)
	{
		Hook::trigger('Yak.Launcher.launchApplication.before');
		self::initSystem();
		self::initApplication($app);
		self::startApplicationWithIntent($app, $intent);
		self::destroyApplication($app);
		Hook::trigger('Yak.Launcher.launchApplication.after');

	}

	public static function initSystem()
	{
		Hook::trigger('Yak.Launcher.initSystem.before');
		Event::init();
		Input::init();
		Router::init();

		Hook::register('NoSuitableRoute', function () {
			Handle(RouteNotFoundHandler::class);
		});

		Hook::trigger('Yak.Launcher.initSystem.after');
	}

	private static function initApplication(YakApplication $app)
	{
		Hook::trigger('Yak.Launcher.startApplication.before');

		Context::setContext(new Context($app));

		Hook::trigger('Yak.Launcher.startApplication.after');
	}

	private static function startApplication(YakApplication $app)
	{
		Hook::trigger('Yak.Launcher.startApplication.before');
		if ($originIntent = Router::detect($app->getRouteRules())) {
			$intent = Router::require($originIntent, [
				'onControllerNotFound' => function (...$arguments) {
					Handle(ControllerNotFoundHandler::class, ...$arguments);
				},
				'onActionNotFound' => function (...$arguments) {
					Handle(ActionNotFoundHandler::class, ...$arguments);
				},
				'onModelNotFound' => function (...$arguments) {
					Handle(ModelNotFoundHandler::class, ...$arguments);
				},
				'onViewNotFound' => function (...$arguments) {
					Handle(ViewNotFoundHandler::class, ...$arguments);
				}
			], [
				'originIntent' => $originIntent
			]);
			if ($intent) {
				Router::direct($intent);
			}
		} else {
			Handle(DefaultRouteHandler::class);
		}
		Hook::trigger('Yak.Launcher.startApplication.after');
	}

	private static function startApplicationWithIntent(YakApplication $app, YakRouteIntent $intent)
	{
		Hook::trigger('Yak.Launcher.startApplication.before');
		Router::direct($intent);
		Hook::trigger('Yak.Launcher.startApplication.after');
	}

	private static function destroyApplication(YakApplication $app)
	{
		Hook::trigger('Yak.Launcher.destroyApplication.before');

		Hook::trigger('Yak.Launcher.destroyApplication.after');

	}

}