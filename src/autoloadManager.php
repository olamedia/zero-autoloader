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

/**
 * autoloadManager
 * Manager for autoloader implementations
 * Introducing namespace/prefix autoloading
 *
 * @package zero
 * @subpackage autoload
 * @author olamedia
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class autoloadManager{
	protected static $_instance = null;
	protected $_namespaceLoaders = array();
	protected $_cacheLoaders = array();
	protected $_cache = array();
	protected $_classLoaders = array();
	protected function __construct(){
		\spl_autoload_register(array($this, 'autoload'));
	}
	public static function getInstance(){
		if (null === self::$_instance){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	public function cache($class, $filename){
		foreach ($this->_cache as $callback){
			if (\call_user_func_array($callback, array($class, $filename))){
				//return true;
			}
		}
	}
	public function registerClassLoader($loader){
		$this->_classLoaders[] = $loader;
	}
	public function registerCacheLoader($loader){
		$this->_cacheLoaders[] = $loader;
	}
	public function registerCache($cache){
		$this->_cache[] = $cache;
	}
	public function registerNamespaceLoader($loader){
		$this->_namespaceLoaders[] = $loader;
	}
	public function autoload($class){
		foreach ($this->_namespaceLoaders as $loader){
			if (\call_user_func($loader, $class)){
				break;
			}
		}
		foreach ($this->_cacheLoaders as $loader){
			if (\call_user_func($loader, $class)){
				return true;
			}
		}
		foreach ($this->_classLoaders as $loader){
			if (\call_user_func($loader, $class)){
				return true;
			}
		}
		return false;
	}
}


