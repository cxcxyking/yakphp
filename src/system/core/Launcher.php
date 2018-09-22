<?php

namespace Yak\System;

use YakRouteIntent;
use YakApplication;
use Yak\System\Handler\ApplicationActionNotFoundHandler;
use Yak\System\Handler\ApplicationControllerNotFoundHandler;
use Yak\System\Handler\ApplicationDefaultRouteHandler;
use Yak\System\Handler\ApplicationModelNotFoundHandler;
use Yak\System\Handler\RouteNotFoundHandler;
use Yak\System\Handler\ApplicationViewNotFoundHandler;

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
		Hook::register('NoSuitableRoute', [RouteNotFoundHandler::class, 'handle']);
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
		if (($match = Router::match($app->getRouteRules())) !== null) {
			$success = function (YakRouteIntent $origin, array $props) {
				return new YakRouteIntent($origin->getApplication(), $props, $origin->getStore());
			};
			$failure = function (YakRouteIntent $origin, $step) {
				if (DefaultRouteEnabled($origin->getApplication())) {
					ApplicationDefaultRouteHandler::handle($origin);
				} else {
					switch ($step) {
						case 'controller':
							ApplicationControllerNotFoundHandler::handle($origin);
							break;
						case 'action':
							ApplicationActionNotFoundHandler::handle($origin);
							break;
						case 'model':
							ApplicationModelNotFoundHandler::handle($origin);
							break;
						case 'view':
							ApplicationViewNotFoundHandler::handle($origin);
							break;
						default:
							break;
					}
				}
			};
			if (($intent = Router::fetch($match, $success, $failure)) !== null) {
				Router::direct($intent);
			}
		} else {
			Hook::trigger('NoSuitableRoute');
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