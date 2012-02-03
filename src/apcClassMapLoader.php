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

use zero\autoloadManager;

/**
 * apcClassMapLoader
 * Class map APC cache
 * ::create('key-prefix', $ttl)
 *
 * @package zero
 * @subpackage autoload
 * @author olamedia
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class apcClassMapLoader{
	protected $_keyPrefix = null;
	protected $_ttl = 60;
	public function __construct($keyPrefix = 'class:', $ttl = 60){
		$this->_keyPrefix = $keyPrefix;
		$this->_ttl = $ttl;
		if (\function_exists('apc_fetch')){
			autoloadManager::getInstance()->registerCacheLoader(array($this, 'loadClass'));
			autoloadManager::getInstance()->registerCache(array($this, 'cache'));
		}
	}
	public function cache($name, $filename){
		if (!\function_exists('apc_fetch')){
			return;
		}
		$key = $this->_keyPrefix.$name;
		\apc_store($key, $filename, $this->_ttl);
	}
	public static function create(){
		$args = \func_get_args();
		$class = new \ReflectionClass(\get_called_class());
		return $class->newInstanceArgs($args);
	}
	public function loadClass($name){
		if (!\function_exists('apc_fetch')){
			return;
		}
		$key = $this->_keyPrefix.$name;
		if (\apc_exists($key)){
			//\apc_delete($key);
			$fn = \apc_fetch($key);
			if (\is_file($fn)){
				include $fn;
				return true;
			}
		}
	}
}


