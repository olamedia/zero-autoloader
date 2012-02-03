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
 * prefixLoader
 * Prefix autoloader implementation for autoloadManager
 * ::getInstance()->register(array(prefix => path), __DIR__)
 *
 * @package zero
 * @subpackage autoload
 * @author olamedia
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class prefixLoader{
	protected static $_instance = null;
	protected $_list = array();
	protected function __construct(){
		autoloadManager::getInstance()->registerNamespaceLoader(array($this, 'autoload'));
	}
	public static function getInstance(){
		if (null === self::$_instance){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	public function register($list, $path = null){
		foreach ($list as $k => $v){
			$this->_list[$k] = ($path===null?'':$path.\DIRECTORY_SEPARATOR).$v;
		}
	}
	public function autoload($class){
		if (empty($this->_list)){
			return false;
		}
		$ns = \explode('_', $class);
		\array_pop($ns);
		while (!empty($ns)){
			if ($this->loadPrefix(\implode('_', $ns))){
				return true;
			}
			\array_pop($ns);
		}
		return false;
	}
	public function loadPrefix($prefix){
		if (isset($this->_list[$prefix])){
			$fn = $this->_list[$prefix];
			if (\is_file($fn)){
				include $fn;
				unset($this->_list[$prefix]);
				return true;
			}
		}
		return false;
	}
}


