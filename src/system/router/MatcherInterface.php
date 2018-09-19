<?php

namespace Yak\System\Router;

use YakRouteRule;

interface MatcherInterface
{
    static function match(YakRouteRule $rule): bool;

    static function parse(YakRouteRule $rule): array;
}