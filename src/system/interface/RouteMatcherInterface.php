<?php

namespace Yak\System;

use YakRouteRule;

interface RouteMatcherInterface
{
    static function match(YakRouteRule $rule): bool;

    static function parse(YakRouteRule $rule): array;
}