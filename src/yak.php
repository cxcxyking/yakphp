<?php

declare (strict_types=1);

define('YAK', 'V0.0.1 - Alpha');

define('YAK_DIR', __DIR__);
define('YAK_LIB', YAK_DIR . '/library/yak');
define('YAK_ORG', YAK_DIR . '/library/org');
define('YAK_SYS', YAK_DIR . '/system');
define('YAK_INC', YAK_DIR . '/include');
define('YAK_CST', YAK_INC . '/constant');
define('YAK_FUN', YAK_INC . '/function');
define('YAK_DAT', YAK_DIR . '/data');
define('YAK_LOG', YAK_DAT . '/logs');
define('YAK_TMP', YAK_DAT . '/temp');
define('YAK_CAC', YAK_DAT . '/cache');
define('YAK_RTM', YAK_DAT . '/runtime');
define('YAK_CFG', YAK_DIR . '/config');
define('YAK_APP', YAK_DIR . '/app');

if (PHP_VERSION < '7') {
    die('The php version was older, please upgrade to php7 or greater. (minimum required: php >= 7.0.0)');
}

function write_log(string $name, string $content, array $attachedInfo = [])
{
    $logFileName = 'log_' . date('ymdHis') . '_' . random_int(10000, 99999) . '.txt';
    $logFilePath = YAK_LOG . '/' . $logFileName;
    $attachedInfoStr = '';
    foreach ($attachedInfo as $name => $value) {
        $attachedInfoStr .= $name . ' => ' . $value . "\n";
    }
    if (!is_writable($logFilePath)) {
        file_put_contents($logFilePath, sprintf("Time: %s\nName: %s\nMessage: %s\n======\nAttached Information: \n%s", date('r'), $name, $content, $attachedInfoStr));
    } else {
        die('System was tried saving a log, but have not the write permission.');
    }
    return $logFileName;
}


// Load constant definitions.

$sourceFiles = glob(YAK_CST . '/*.php');

foreach ($sourceFiles as $file) {
    include_once $file;
}

// Load core components of Yak.

$sourceFiles = glob(YAK_SYS . '/*/*.php');
// var_dump($sourceFiles);

foreach ($sourceFiles as $file) {
    require_once $file;
}

$sourceFiles = glob(YAK_SYS . '/*.php');
// var_dump($sourceFiles);

foreach ($sourceFiles as $file) {
    require_once $file;
}

$sourceFiles = glob(YAK_DIR . '/api/*.php');

foreach ($sourceFiles as $file) {
    require_once $file;
}

require YAK_ORG . '/smarty-3.1.33/libs/bootstrap.php';

$sourceFiles = glob(YAK_APP . '/ComponentNotFound/**/*.php');

foreach ($sourceFiles as $file) {
    require_once $file;
}