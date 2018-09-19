<?php

return [
    new YakRouteRule(YAK_PATH_ROUTE, '/{controller}/{action}/{model}/{view}'),
    new YakRouteRule(YAK_QUERY_ROUTE, 'c={controller}&a={action}&m={model}&v={view}')
];