<?php

abstract class YakModelAbstract
{
    private $_store = [];

    final public function get(string $key, $default)
    {
        return $this->_store[$key] ?? $default;
    }

    final public function set(string $key, $value)
    {
        $this->_store[$key] = $value;
    }
}