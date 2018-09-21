<?php

namespace Yak\System;

class YakAutoLoadHandler extends Handler
{
	public function handle(...$arguments): int
	{
		$class = $arguments[0];

		if ($this->do($class)) {
			return YAK_HANDLE_SUCCESS;
		} else {
			return YAK_HANDLE_FAILURE;
		}
	}

	private function do(string $class): bool
	{
		if (substr($class, 0, 3) !== 'Yak') {
			return false;
		}
		if (preg_match('/^Yak[0-9A-Z][0-9A-Za-z_]*$/', $class) === 1) {
			require YAK_DIR . '/api/' . $class . '.php';
			return true;
		}
		if (preg_match('/^Yak\\\System\\\([A-Z][0-9A-Za-z_]*(\\\[A-Z][0-9A-Za-z_]*)*)$/', $class, $match) === 1) {
			$path = str_replace('\\', '/', $match[1]);
			if (is_file(YAK_SYS . '/' . $path . '.php')) {
				require YAK_SYS . '/' . $path . '.php';
			} elseif (is_file(YAK_SYS . '/core/' . $path . '.php')) {
				require YAK_SYS . '/core/' . $path . '.php';
			} elseif (preg_match('/Interface$/', $path) === 1) {
				require YAK_SYS . '/interface/' . $path . '.php';
			} elseif (preg_match('/Handler$/', $path) === 1) {
				require YAK_SYS . '/handler/' . $path . '.php';
			}
			var_dump($path);
			return true;
		}
		echo 'No matches';
		return false;
	}
}