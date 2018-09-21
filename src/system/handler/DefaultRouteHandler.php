<?php

namespace Yak\System;

use YakRouteIntent;

class DefaultRouteHandler extends Handler
{

	public function handle(...$arguments): int
	{
		$this->do(...$arguments);
		return YAK_HANDLE_SUCCESS;
	}

	private function do()
	{
		$app = Context::getApplication();
		$controller = $app->getSettings('default.controller');
		$action = $app->getSettings('default.action');
		$model = $app->getSettings('default.model');
		$view = $app->getSettings('default.view');
		if ($controller && $action && $model && $view) {
			Hook::register('Yak.Launcher.launchApplication.after', function ($id) use ($controller, $action, $model, $view) {
				Hook::delete($id);
				$originIntent = new YakRouteIntent($controller, $action, $model, $view);
				if (($intent = Router::require($originIntent, [])) !== null) {
					Launcher::launchApplicationWithIntent(Context::getApplication(), $intent);
				} else {
					Hook::trigger('NoSuitableRoute');
				}
			});
		} else {
			Hook::trigger('NoSuitableRoute');
		}
	}
}