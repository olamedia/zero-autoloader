<?php

/*
 * This file is part of the zero package.
 * Copyright (c) 2012 olamedia <olamedia@gmail.com>
 *
 * This source code is release under the MIT License.
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace zero;

use zero\classMapLoader;
// use zero\apcClassMapLoader;

require __DIR__.'/src/autoloadManager.php';
require __DIR__.'/src/classMapLoader.php';

classMapLoader::create(array(
	// Autoload
	'namespaceLoader' => 'namespaceLoader.php',
	'prefixLoader' => 'prefixLoader.php',
	'apcClassMapLoader' => 'apcClassMapLoader.php',
	'psr0Loader' => 'psr0Loader.php',
), __DIR__.'/src', 'zero');

// apcClassMapLoader::create($_SERVER['SERVER_NAME'].':class:');

