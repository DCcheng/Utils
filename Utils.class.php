<?php
	/**
	* 类名：Utils
	* 作用：工具类入口
	* 作者：DC
	* 时间：2015年8月27日 11:09:40
	* 版本：v1.0
	*/
	class Utils
	{
		private $Utils = array();
		public static $Obj = null;
		//类的入口
		public static function init($class_name){
			// $args = func_get_args();
			if(Utils::$Obj == null){
				Utils::$Obj = new Utils();
			}
			Utils::$Obj->setClass($class_name);
			return Utils::$Obj->Utils[$class_name];
		}

		private	function setClass($class_name){
			//类名
            $class_name = ucwords(strtolower($class_name));
			if(!isset($this->Utils[$class_name])){
				$className = $class_name."Utils";
				include_once dirname(__FILE__)."/$className.class.php";
				$this->Utils[$class_name] = new $className();
			}
		}
	}
?>