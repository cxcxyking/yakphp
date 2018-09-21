<?php

use Yak\System\Launcher;
use Yak\System\Application;

class YakLauncher
{
	public static function run(YakApplication $app)
	{
		Launcher::launchApplication($app);
	}
}