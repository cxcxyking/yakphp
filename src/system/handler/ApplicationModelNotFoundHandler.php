<?php

namespace Yak\System\Handler;

use YakApplication;
use YakRouteIntent;
use Yak\System\Handler;
use Yak\System\Hook;
use Yak\System\Router;
use Yak\System\Launcher;

class ApplicationModelNotFoundHandler extends Handler
{

	public static function handle(...$arguments): int
	{
		$originIntent = $arguments[0];
		self::do($originIntent);
		return YAK_HANDLE_SUCCESS;
	}

	private static function do(YakRouteIntent $origin)
	{
		Hook::register('Yak.Launcher.launchApplication.after', function ($id) use ($origin) {
			Hook::delete($id);
			Router::status('503');
			Launcher::launchApplicationWithIntent(
				new YakApplication('ComponentNotFound', YAK_APP . '/ComponentNotFound'),
				new YakRouteIntent($origin->getApplication(), ['action' => [\YakInstance\ComponentNotFound\Controller\Home::class, 'modelNotFound']], ['target' => $origin->getTarget()])
			);
		});
	}
}