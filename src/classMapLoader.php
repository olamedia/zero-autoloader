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
 * classMapLoader
 * Class map autoloader
 * ::create(array(class => file), __DIR__, 'name\\space')
 *
 * @package zero
 * @subpackage autoload
 * @author olamedia
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class classMapLoader{
	protected $_map = array();
	protected $_path = null;
	protected $_namespace = null;
	public function __construct($map = array(), $path = null, $namespace = null){
		$this->_map = $map;
		$this->_path = $path;
		$this->_namespace = $namespace;
		autoloadManager::getInstance()->registerClassLoader(array($this, 'loadClass'));
	}
	public static function create(){
		$args = \func_get_args();
		$class = new \ReflectionClass(\get_called_class());
		$constructor = $class->getConstructor();
		if ($constructor->isPublic()){
			$instance = $class->newInstanceArgs($args);
		}else{
			$constructor->setAccessible(true);
			$instance = $class->newInstanceWithoutConstructor();
			$constructor->invokeArgs($instance, $args);
		}
		return $instance;
	}
	public function loadClass($class){
		if ($this->_namespace !== null){
			if (\substr($class, 0, \strlen($this->_namespace)+1) != $this->_namespace.'\\'){
				return false;
			}
		}
		$left = \substr($class, \strlen($this->_namespace)+1);
		if (isset($this->_map[$left])){
			$fn = (string) ($this->_path === null?'':$this->_path.\DIRECTORY_SEPARATOR).$this->_map[$left];
			if (\is_file($fn)){
				include $fn;
				autoloadManager::getInstance()->cache($class, $fn);
				unset($this->_map[$left]);
				return true;
			}else{
				require $fn;
				\clearstatcache(true);
				throw new \Exception('File not found "'.$fn.'". Class: "'.$class.'".');
			}
		}
		return false;
	}
}
