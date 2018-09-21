<?php

namespace Yak\System;

use YakApplication;
use YakRouteIntent;

class ModelNotFoundHandler extends Handler
{

	public function handle(...$arguments): int
	{
		$originIntent = $arguments[0];
		$this->do($originIntent);
		return YAK_HANDLE_SUCCESS;
	}

	private function do(YakRouteIntent $originIntent)
	{
		Hook::register('Yak.Launcher.launchApplication.after', function ($id) use ($originIntent) {
			Hook::delete($id);
			Router::status('503');
			Launcher::launchApplicationWithIntent(
				new YakApplication('ComponentNotFound', YAK_APP . '/ComponentNotFound'),
				new YakRouteIntent(\YakInstance\ComponentNotFound\Controller\Home::class, 'modelNotFound', '', '', ['originIntent' => $originIntent])
			);
		});
	}
}