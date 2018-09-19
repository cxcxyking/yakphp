<?php

namespace Yak\System;

use YakRouteIntent;

class Launcher
{
    public static function launchApplication(Application $app)
    {
        Hook::trigger('Yak.Launcher.launchApplication.before');
        self::initSystem();
        self::initApplication($app);
        self::startApplication($app);
        self::destroyApplication($app);
        Hook::trigger('Yak.Launcher.launchApplication.after');
    }

    public static function launchApplicationWithIntent(Application $app, YakRouteIntent $intent)
    {
        Hook::trigger('Yak.Launcher.launchApplication.before');
        self::initSystem();
        self::initApplication($app);
        self::startApplicationWithIntent($app, $intent);
        self::destroyApplication($app);
        Hook::trigger('Yak.Launcher.launchApplication.after');

    }

    private static function initSystem()
    {
        static $initial = true;
        if ($initial) {
            Hook::trigger('Yak.Launcher.initSystem.before');
            self::_initSystem();
            $initial = false;
            Hook::trigger('Yak.Launcher.initSystem.after');
        }
    }

    private static function _initSystem()
    {
        Input::init();
        Router::init();
    }

    private static function initApplication(Application $app)
    {
        Hook::trigger('Yak.Launcher.startApplication.before');

        Context::setContext(new Context($app));

        Hook::trigger('Yak.Launcher.startApplication.after');
    }

    private static function startApplication(Application $app)
    {
        Hook::trigger('Yak.Launcher.startApplication.before');
        if ($originIntent = Router::detect($app->getRouteRules())) {
            if ($intent = Router::require($originIntent, ['originIntent' => $originIntent])) {
                Router::direct($intent);
            }
        } else {
            RouteNotFoundHandler();
        }
        Hook::trigger('Yak.Launcher.startApplication.after');
    }

    private static function startApplicationWithIntent(Application $app, YakRouteIntent $intent)
    {
        Hook::trigger('Yak.Launcher.startApplication.before');
        Router::direct($intent);
        Hook::trigger('Yak.Launcher.startApplication.after');
    }

    private static function destroyApplication(Application $app)
    {
        Hook::trigger('Yak.Launcher.destroyApplication.before');

        Hook::trigger('Yak.Launcher.destroyApplication.after');

    }

}