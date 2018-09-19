<?php

class YakRouteIntent
{
    private $controller;
    private $action;
    private $model;
    private $view;
    private $bundle = [];

    public function __construct(string $controller, string $action, string $model, string $view, array $bundle = [])
    {
        $this->controller = $controller;
        $this->action = $action;
        $this->model = $model;
        $this->view = $view;
        $this->bundle = $bundle;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getView()
    {
        return $this->view;
    }

    public function getBundle()
    {
        return $this->bundle;
    }

    public function get(string $key, $default = null)
    {
        return $this->bundle[$key] ?? $default;
    }
}
