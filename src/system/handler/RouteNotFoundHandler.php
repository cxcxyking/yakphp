<?php

namespace Yak\System;

use YakApplication;
use YakRouteIntent;

class RouteNotFoundHandler extends Handler
{

	public function handle(...$arguments): int
	{
		$this->do();
		return YAK_HANDLE_SUCCESS;
	}

	private function do()
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