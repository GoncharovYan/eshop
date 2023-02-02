<?php

const ROOT = __DIR__;

function requireClassByNamespace(string $prefix, string $dir, string $class): void
{
	$len = strlen($prefix);

	// get the relative class name
	// by replacing the Core prefix with the base directory
	$relativeClass = substr($class, $len);

	// replace namespace separators with directory separators
	// in the class name, append with .php
	$file = $dir . str_replace('\\', '/', $relativeClass) . '.php';

	// if the file exists, require it
	if (file_exists($file)) {
		require $file;
	}
}

// Check core directory
spl_autoload_register(function ($class) {

	// this autoloader is for Core only
	$prefix = 'Core';

	// does the class use Core prefix?
	// compare first (len) characters of class name with Core
	$len = strlen($prefix);
	if (strncmp($prefix, $class, $len) !== 0) {
		// no, move to the next
		return;
	}

	// Class base directory
	$baseDir = __DIR__ . '/core/';

	requireClassByNamespace($prefix, $baseDir, $class);
});

// Check src directory
spl_autoload_register(function ($class) {

	$prefix = '';

	$baseDir = __DIR__ . '/src/';

	requireClassByNamespace($prefix, $baseDir, $class);
});