<?php

declare (strict_types=1);

use function Yak\System\Handle;
use Yak\System\YakAutoLoadHandler;

define('YAK', 'V0.0.1 - Alpha');

define('LIB_DIR', dirname(__DIR__) . '/libs');

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

foreach (glob(YAK_CST . '/*.php') as $file) {
	require_once $file;
}

// Load utility functions

foreach (glob(YAK_FUN . '/*.php') as $file) {
	require_once $file;
}

// Load system functions

foreach (glob(YAK_SYS . '/function/*.php') as $file) {
	require_once $file;
}

// Register system autoloader

spl_autoload_register(function (string $class) {
	if (substr($class, 0, 4) !== 'Yak\\') {
		return;
	}
	$map = array(
		'Yak\\System\\Handler' => YAK_SYS . '/abstract/Handler.php'
	);
	if (isset($map[$class])) {
		require $map[$class];
	} elseif (preg_match('/^Yak\\\System\\\([A-Z][0-9A-Za-z_]*(?:\\\([A-Z][0-9A-Za-z_]*))*)$/', $class, $match) === 1) {
		$comp = explode('\\', $match[1]);
		$path = implode('/', $comp);
		if (is_file(YAK_SYS . '/' . $path . '.php')) {
			require YAK_SYS . '/' . $path . '.php';
		} elseif (is_file(YAK_SYS . '/core/' . $path . '.php')) {
			require YAK_SYS . '/core/' . $path . '.php';
		} elseif (preg_match('/^[A-Z][0-9A-Za-z_]*Interface$/', $path) === 1) {
			require YAK_SYS . '/interface/' . $path . '.php';
		} elseif (preg_match('/^[A-Z][0-9A-Za-z_]*Handler$/', $path) === 1) {
			require YAK_SYS . '/handler/' . $path . '.php';
		}
	}
});

spl_autoload_register(function (string $class) {
	if (substr($class, 0, 12) !== 'YakInstance\\') {
		return;
	}
	if (preg_match('/^YakInstance\\\([0-9A-Za-z_]+)\\\([A-Z][0-9A-Za-z_]*(?:\\\([A-Z][0-9A-Za-z_]*))*)$/', $class, $match) === 1) {
		require \Yak\System\Context::getApplication()->getPath() . '/' . $match[2] . '.php';
	}
});

// Load APIs

foreach (glob(YAK_DIR . '/api/*.php') as $file) {
	require_once $file;
}

require LIB_DIR . '/smarty-3.1.33/libs/bootstrap.php';