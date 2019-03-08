<?php
	interface CacheInterface{

		//转换文件名
		// public function getFileName($key);

		//设置缓存数据
		public function set($key,$value);

		//获取缓存数据
		public function get($key);

		//删除缓存数据
		public function del($key);

		//清空缓存数据
		public function clean();
	}
?>