<?php

class YakApplication
{
    private $name;
    private $path;
    private $authors;
    private $options;
    private $settings;

    public function __construct(string $name, string $path, array $authors, array $options = [], array $settings = [])
    {
        $this->name = $name;
        $this->pathValidate($path);
        $this->path = $path;
        $this->authors = $authors;
        $this->options = $options;
        $this->settings = $settings;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getPath() : string
    {
        return $this->path;
    }

    public function getAuthors() : array
    {
        return $this->authors;
    }

    public function getOptions() : array
    {
        return $this->options;
    }

    public function getSettings() : array
    {
        return $this->settings;
    }

    private function pathValidate(string $path)
    {
        if (!is_dir($path)) {
            die('Application path must be a valid directory and must be exists.');
        }
    }
}