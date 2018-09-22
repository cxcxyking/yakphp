<?php

class YakRouteIntent
{
	private $app;
	private $target;
	private $store = [];

	public function __construct(YakApplication $app, YakRouteTarget $target, array $store = [])
	{
		$this->app = $app;
		$this->target = $target;
		$this->store = $store;
	}

	public function getApplication()
	{
		return $this->app;
	}

	public function getTarget()
	{
		return $this->target;
	}

	public function getStore()
	{
		return $this->store;
	}

	public function get(string $key, $default = null)
	{
		return $this->store[$key] ?? $default;
	}
}
