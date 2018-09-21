<?php

use Yak\System\Hook;

class YakApplication
{
	private $name;
	private $path;
	private $originOptions = [];
	private $originSettings = [];
	private $options = [];
	private $settings = [];
	private $routeRules = [];

	public function __construct(string $name, string $path, array $options = [], array $settings = [])
	{
		Hook::trigger('YakApplication.before');
		$this->pathValidate($path);
		$this->name = $name;
		$this->path = $path;
		$this->originOptions = $options;
		$this->originSettings = $settings;
		$this->updateOptions();
		$this->updateSettings();
		$this->updateRouteRules();
		Hook::trigger('YakApplication.after');
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getPath(): string
	{
		return $this->path;
	}

	public function getRawOptions(): array
	{
		return $this->options;
	}

	public function getRawSettings(): array
	{
		return $this->settings;
	}

	public function getOption(string $name, $default = null)
	{
		return yak_array_get($this->options, $name, $default);
	}

	public function setOption(string $name, $value)
	{
		yak_array_set($this->options, $name, $value);
	}

	public function getSettings(string $name, $default = null)
	{
		return yak_array_get($this->settings, $name, $default);
	}

	public function setSettings(string $name, $value)
	{
		yak_array_set($this->settings, $name, $value);
	}

	public function getControllerDir(): string
	{
		return $this->path . '/controller';
	}

	public function getModelDir(): string
	{
		return $this->path . '/model';
	}

	public function getViewDir(): string
	{
		return $this->path . '/view';
	}

	public function getConfigDir(): string
	{
		return $this->path . '/config';
	}

	public function getNamespace(): string
	{
		return 'YakInstance\\' . $this->getName();
	}

	/**
	 * @return YakRouteRule[]
	 */
	public function getRouteRules(): array
	{
		return $this->routeRules;
	}

	private function updateOptions()
	{
		static $firstLock = true;
		if ($firstLock) {
			$optionsConfigPath = $this->getPath() . '/config/options.php';
			if (is_file($optionsConfigPath)) {
				$importedOptions = require $optionsConfigPath;
				$this->options = array_merge($this->options, is_array($importedOptions) ? $importedOptions : [], $this->originOptions);
			}
			$firstLock = false;
		}

	}

	private function updateSettings()
	{
		static $firstLock = true;
		if ($firstLock) {
			$settingsConfigPath = $this->getPath() . '/config/settings.php';
			if (is_file($settingsConfigPath)) {
				$importedSettings = require $settingsConfigPath;

				$this->settings = array_merge($this->settings, is_array($importedSettings) ? $importedSettings : [], $this->originSettings);
			}
			$firstLock = false;
		}
	}

	private function updateRouteRules()
	{
		static $firstLock = true;
		if ($firstLock) {
			$routeRulesConfigPath = $this->getPath() . '/config/route.php';
			if (is_file($routeRulesConfigPath)) {
				$importedRules = require $routeRulesConfigPath;
				for ($i = 0; $i < count($importedRules); $i++) {
					array_push($this->routeRules, $importedRules[$i]);
				}
			}
			$firstLock = false;
		}
	}

	private function pathValidate(string $path)
	{
		if (!is_dir($path)) {
			die('Application path must be a valid directory and must be exists.');
		}
	}
}