<?php

use Yak\System\Launcher;
use Yak\System\Application;

class YakLauncher
{
    public static function run(YakApplication $app)
    {
        Launcher::launchApplication(new Application($app->getName(), $app->getPath(), $app->getOptions(), $app->getSettings()));
    }
}