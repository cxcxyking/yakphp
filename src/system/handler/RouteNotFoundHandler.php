<?php

namespace Yak\System\Handler;

use YakApplication;
use YakRouteIntent;
use Yak\System\Handler;
use Yak\System\Hook;
use Yak\System\Router;
use Yak\System\Launcher;

class RouteNotFoundHandler extends Handler
{

	public static function handle(...$arguments): int
	{
		self::do();
		return YAK_HANDLE_SUCCESS;
	}

	private static function do()
	{
		Hook::register('Yak.Launcher.launchApplication.after', function ($id) {
			Hook::delete($id);
			Router::status('503');
			Launcher::launchApplicationWithIntent(
				new YakApplication('ComponentNotFound', YAK_APP . '/ComponentNotFound'),
				new YakRouteIntent(\YakInstance\ComponentNotFound\Controller\Home::class, 'routeNotFound', '', '')
			);
		});
	}
}