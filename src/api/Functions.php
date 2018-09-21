<?php

function yak_array_get(array &$arr, string $keyPath, $default)
{
	$found = true;
	$current = $arr;
	foreach (explode('.', $keyPath) as $key) {
		if (isset($current[$key])) {
			$current = $current[$key];
		} else {
			$found = false;
			break;
		}
	}
	return $found ? $current : $default;
}

function yak_array_set(array &$arr, string $keyPath, $value)
{
	$current = &$arr;
	$kp = explode('.', $keyPath);
	$last = array_pop($kp);
	foreach ($kp as $key) {
		if (!isset($current[$key]) || !is_array($current[$key])) {
			$current[$key] = [];
		}
		$current = &$current[$key];
	}
	$current[$last] = $value;
}