<?php
	/**
	* 类名：EmailUtils
	* 作用：邮件发送工具类
	* 作者：DC
	* 时间：2015年8月27日 11:36:09
	* 版本：v1.0
	*/
	include_once dirname(__FILE__)."/cache/Filecache.class.php";
	include_once dirname(__FILE__)."/cache/Memcachedcache.class.php";
	class CacheUtils
	{
		private $obj = null;
		public	function __construct(){
			if($this->obj == null){
				$this->obj = new Filecache(); 
			}
		}

		public function set($key,$value){
			return false;
			return $this->obj->set($key,$value);
		}

		public function get($key){
			return false;
			return $this->obj->get($key);
		}

		public function del($key){
			return false;
			return $this->obj->del($key);
		}

		public function clean(){
			return false;
			return $this->obj->clean();
		}
	}
?>