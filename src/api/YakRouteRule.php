<?php

use Yak\System\Router\Rule;

class YakRouteRule
{
    private $type;
    private $rule;
    private $options;

    public function __construct(int $type, string $rule, array $options = [])
    {
        $this->type = $type;
        $this->rule = $rule;
        $this->options = $options;
    }

    public function getType() : int
    {
        return $this->type;
    }

    public function getRule() : string
    {
        return $this->rule;
    }

    public function getOptions() : array
    {

        return $this->options;
    }
}