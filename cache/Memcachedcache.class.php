<?php

	/**
	* 
	*/
	require_once(dirname(__FILE__).'/CacheInterface.php');
	class Memcachedcache implements CacheInterface
	{
		private $memcache = null;
		private $host = array("192.168.8.62");
		private $port = 11211;
		private $time = 7200;
		private $is_connect = false;

		public function __construct()
		{
			$this->memcache = new Memcache;
			$this->connect();
		}

		public function connect(){
			foreach ($this->host as $key => $value) {
				$this->memcache->addServer($value, $this->port);
			}
		}

		public function checkConnect(){
			$bool = false;
			foreach ($this->host as $key => $value) {
				if(!$bool){
					$bool = $this->memcache->getServerStatus($value,$this->port);
				}
			}
			return $bool;
		}

		//添加缓存
		public function set($key,$value){
			if($this->checkConnect()){	
				$this->memcache->set($key,$value,MEMCACHE_COMPRESSED,$this->time);
			}
		}

		//获取缓存
		//判断是否失效
		public function get($key){
			if($this->checkConnect()){	
				return $this->memcache->get($key);
			}else{ 
				return false;
			}
		}

		//删除对应的key的缓存
		public function del($key){
			if($this->checkConnect()){	
				$this->memcache->delete($key);
			}
		}

		//清除所有缓存
		public function clean(){
			if($this->checkConnect()){	
				$this->memcache->flush();
			}
		}
	}
?>