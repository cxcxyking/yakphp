<?php

namespace Yak\System\Handler;

use YakRouteIntent;
use Yak\System\Hook;
use Yak\System\Router;
use Yak\System\Handler;
use Yak\System\Launcher;

class ApplicationDefaultRouteHandler extends Handler
{

	public static function handle(...$arguments): int
	{
		self::do(...$arguments);
		return YAK_HANDLE_SUCCESS;
	}

	private static function do(YakRouteIntent $origin)
	{
		Hook::register('Yak.Launcher.launchApplication.after', function ($id) use ($origin) {
			Hook::delete($id);
			$intent = Router::fetch(
				new YakRouteIntent($origin->getApplication(), $origin->getApplication()->getSettings('route.default'), $origin->getStore()),
				function (YakRouteIntent $origin, array $props) {
					return new YakRouteIntent($origin->getApplication(), $props, $origin->getStore());
				},
				function (YakRouteIntent $origin, $step) {
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
			);
			if ($intent !== null) {
				Launcher::launchApplicationWithIntent($origin->getApplication(), $intent);
			}
		});
	}
}