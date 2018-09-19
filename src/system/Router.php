<?php

namespace Yak\System;

use YakRouteIntent;
use Yak\System\Router\PathRuleMatcher;
use Yak\System\Router\QueryRuleMatcher;

class Router
{
    private static $matchers = [];
    private static $httpStatusCode = [];

    public static function setRuleMatcher(int $type, string $matcher)
    {
        self::$matchers[$type] = $matcher;
    }

    public static function init()
    {
        $httpStatusCodes = require YAK_DAT . '/HttpStatus.php';
        self::$httpStatusCode = $httpStatusCodes['1.1'];
    }

    /**
     * @param \YakRouteRule[] $rules
     * @return null|YakRouteIntent
     */
    public static function detect(array $rules)
    {
        foreach ($rules as $rule) {
            if ($matcher = self::$matchers[$rule->getType()] ?? null) {
                if (call_user_func([$matcher, 'match'], $rule)) {
                    $strategy = call_user_func([$matcher, 'parse'], $rule);
                    return new YakRouteIntent($strategy['controller'], $strategy['action'], $strategy['model'], $strategy['view']);
                }
            }
        }
        return null;
    }

    public static function require(YakRouteIntent $intent, array $args = [])
    {
        if (($controller = self::validateController($intent->getController())) === '') {
            ControllerNotFoundHandler($intent);
            return null;
        }
        if (($action = self::validateAction($controller, $intent->getAction())) === '') {
            ActionNotFoundHandler($intent);
            return null;
        };
        if (($model = self::validateModel($intent->getModel())) === '') {
            ModelNotFoundHandler($intent);
            return null;
        }
        if (($view = self::validateView($intent->getView())) === '') {
            ViewNotFoundHandler($intent);
            return null;
        }
        return new YakRouteIntent($controller, $action, $model, $view, array_merge($intent->getBundle(), $args));
    }

    public static function direct(YakRouteIntent $intent)
    {
        $controller = $intent->getController();
        call_user_func([new $controller($intent), $intent->getAction()], $intent);
    }

    public static function status(string $code)
    {
        if (isset(self::$httpStatusCode[$code])) {
            header(self::$httpStatusCode[$code]);
        }
    }

    private static function validateController(string $controller)
    {
        if (is_file($controllerFilePath = Context::getApplication()->getControllerDir() . '/' . $controller . '.php')) {
            require $controllerFilePath;
        } else {
            return '';
        }
        if (class_exists($controllerClass = Context::getApplication()->getNamespace() . '\\Controller\\' . $controller)) {
            return $controllerClass;
        } else {
            return '';
        }
    }

    private static function validateAction(string $controller, string $action)
    {
        if (class_exists($controller) && method_exists($controller, $action)) {
            return $action;
        } else {
            return '';
        }
    }

    private static function validateModel(string $model)
    {
        if (is_file($modelFilePath = Context::getApplication()->getModelDir() . '/' . $model . '.php')) {
            require $modelFilePath;
        } else {
            return '';
        }
        if (class_exists($modelClass = Context::getApplication()->getNamespace() . '\\Model\\' . $model)) {
            return $modelClass;
        } else {
            return '';
        }
    }

    private static function validateView(string $view)
    {
        if (is_file($viewFilePath = Context::getApplication()->getViewDir() . '/' . $view . '.html')) {
            return $view;
        } else {
            return '';
        }
    }
}

Router::setRuleMatcher(YAK_PATH_ROUTE, PathRuleMatcher::class);
Router::setRuleMatcher(YAK_QUERY_ROUTE, QueryRuleMatcher::class);