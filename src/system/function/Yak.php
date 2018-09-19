<?php

namespace Yak\System;

use YakRouteIntent;

function ControllerNotFoundHandler(YakRouteIntent $originIntent)
{
    Hook::register('Yak.Launcher.launchApplication.after', function ($id) use ($originIntent) {
        Hook::delete($id);
        Router::status('503');
        Launcher::launchApplicationWithIntent(
            new Application('ComponentNotFound', YAK_APP . '/ComponentNotFound'),
            new YakRouteIntent(\YakInstance\ComponentNotFound\Controller\Home::class, 'controllerNotFound', '', '', ['originIntent' => $originIntent])
        );
    });
}

function ActionNotFoundHandler(YakRouteIntent $originIntent)
{
    Hook::register('Yak.Launcher.launchApplication.after', function ($id) use ($originIntent) {
        Hook::delete($id);
        Router::status('503');
        Launcher::launchApplicationWithIntent(
            new Application('ComponentNotFound', YAK_APP . '/ComponentNotFound'),
            new YakRouteIntent(\YakInstance\ComponentNotFound\Controller\Home::class, 'actionNotFound', '', '', ['originIntent' => $originIntent])
        );
    });
}

function ModelNotFoundHandler(YakRouteIntent $originIntent)
{
    Hook::register('Yak.Launcher.launchApplication.after', function ($id) use ($originIntent) {
        Hook::delete($id);
        Router::status('503');
        Launcher::launchApplicationWithIntent(
            new Application('ComponentNotFound', YAK_APP . '/ComponentNotFound'),
            new YakRouteIntent(\YakInstance\ComponentNotFound\Controller\Home::class, 'modelNotFound', '', '', ['originIntent' => $originIntent])
        );
    });
}

function ViewNotFoundHandler(YakRouteIntent $originIntent)
{
    Hook::register('Yak.Launcher.launchApplication.after', function ($id) use ($originIntent) {
        Hook::delete($id);
        Router::status('503');
        Launcher::launchApplicationWithIntent(
            new Application('ComponentNotFound', YAK_APP . '/ComponentNotFound'),
            new YakRouteIntent(\YakInstance\ComponentNotFound\Controller\Home::class, 'viewNotFound', '', '', ['originIntent' => $originIntent])
        );
    });
}

function RouteNotFoundHandler()
{
    Hook::register('Yak.Launcher.launchApplication.after', function ($id) {
        Hook::delete($id);
        Router::status('503');
        Launcher::launchApplicationWithIntent(
            new Application('ComponentNotFound', YAK_APP . '/ComponentNotFound'),
            new YakRouteIntent(\YakInstance\ComponentNotFound\Controller\Home::class, 'routeNotFound', '', '')
        );
    });
}