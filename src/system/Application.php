<?php

namespace Yak\System;

class Application
{
    private $name;
    private $path;
    private $passedOptions = [];
    private $passedSettings = [];
    private $options = [];
    private $settings = [];
    private $routeRules = [];

    public function __construct(string $name, string $path, array $options = [], array $settings = [])
    {
        Hook::trigger('YakApplication.before');
        $this->validatePath($path);
        $this->name = $name;
        $this->path = $path;
        $this->passedOptions = $options;
        $this->passedSettings = $settings;
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

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getSettings(): array
    {
        return $this->settings;
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
     * @return \YakRouteRule[]
     */
    public function getRouteRules(): array
    {
        return $this->routeRules;
    }

    private function validatePath(string $path)
    {
        if (!is_dir($path)) {
            die('Application path must be a valid directory and must be exists.');
        }
    }

    private function updateOptions()
    {
        static $firstLock = true;
        if ($firstLock) {
            $optionsConfigPath = $this->getPath() . '/config/options.php';
            if (is_file($optionsConfigPath)) {
                $importedOptions = require $optionsConfigPath;
                $this->options = array_merge($this->options, is_array($importedOptions) ? $importedOptions : [], $this->passedOptions);
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

                $this->settings = array_merge($this->settings, is_array($importedSettings) ? $importedSettings : [], $this->passedSettings);
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
}