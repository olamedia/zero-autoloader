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
 * psr0Loader 
 * PSR-0 implementation
 * ::create(array(prefix => path), __DIR__)
 *
 * @package zero
 * @subpackage autoload
 * @author olamedia
 * @link https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class psr0Loader{
	protected $_path = null;
	protected $_map = array();
	public function __construct($map, $path = null){
		$this->_map = $map;
		$this->_path = $path;
		autoloadManager::getInstance()->registerClassLoader(array($this, 'loadClass'));
	}
	public static function create(){
		$args = \func_get_args();
		$class = new \ReflectionClass(\get_called_class());
		return $class->newInstanceArgs($args);
	}
	public function loadClass($name){
		foreach ($this->_map as $prefix => $path){
			if (0 !== \strpos($name, $prefix)) {
				continue;
			}
			if (null !== $this->_path){
				$path = $this->_path.\DIRECTORY_SEPARATOR.$path;
			}
			$fn = $path.'/'.\str_replace(array('\\', '_', "\0"), array('/', '/', ''), $name).'.php';
			if (\is_file($fn)){
				include $fn;
				autoloadManager::getInstance()->cache($name, $fn);
				return true;
			}
		}
		return false;
	}
}


