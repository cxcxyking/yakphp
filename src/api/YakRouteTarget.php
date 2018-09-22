<?php

class YakRouteTarget
{
	private $controller;
	private $action;
	private $model;
	private $view;

	public function __construct($controller, $action, $model, $view)
	{
		$this->controller = $controller;
		$this->action = $action;
		$this->model = $model;
		$this->view = $view;
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
}