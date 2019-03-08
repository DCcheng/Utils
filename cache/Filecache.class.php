<?php
	/**
	* 类名：LogUtils
	* 作用：日志文件记录工具类
	* 作者：DC
	* 时间：2017年4月26日11:35:49
	* 版本：v1.0
	*/
	require_once(dirname(__FILE__).'/CacheInterface.php');
	class Filecache implements CacheInterface
	{
		private $path = "";
		private $time = 7200;

		public function __construct(){
			$this->path = dirname(__FILE__)."/../../../runtimes/filecaches/";
		}

		public function setConfig($arr){
			foreach ($arr as $key => $value) {
				$this->$key = $value;
			}
			return $this;
		}

		public function getFileName($key){
			$filename=$this->path.md5($key);
			return $filename;
		}

		//添加缓存
		public function set($key,$value){
			$filename=$this->getFileName($key); 
			$fp=fopen("$filename", "w+"); //打开文件指针，创建文件 
			fwrite($fp,serialize($value));
			fclose($fp); //关闭指针 
		}

		//获取缓存并判断是否失效
		public function get($key){
			$filename=$this->getFileName($key); 
			if(file_exists($filename)){
				return (time() - filemtime($filename) - $this->time) >= 0?false:unserialize(file_get_contents($filename));
			}else{
				return false;
			}
		}

		//删除对应的key的缓存
		public function del($key){
			$filename=$this->getFileName($key); 
			if(file_exists($filename)){
				unlink($filename);
			}
		}

		//清除所有缓存
		public function clean(){
			$dh = opendir($this->path);
			while ($file=readdir($dh)) 
			{
				if($file!="." && $file!="..") 
				{
					$fullpath= $this->path.$file;
					unlink($fullpath);
				}
			}
			closedir($dh);
		}
	}
?>