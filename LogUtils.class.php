<?php
	/**
	* 类名：LogUtils
	* 作用：日志文件记录工具类
	* 作者：DC
	* 时间：2017年4月26日11:35:49
	* 版本：v1.0
	*/
	class LogUtils
	{
		private $path = "";
		private $filename = "";
		private $size = 2048000;
		public	function __construct(){
			$this->filename = date("Ymd").".log";
			$this->path = dirname(__FILE__)."/../../runtimes/log/";
		}

		public function setConfig($arr){
			foreach ($arr as $key => $value) {
				$this->$key = $value;
			}
			return $this;
		}

		public function save($msg = ""){

			$this->cut();

			$filename=$this->path.$this->filename; 
			$fp=fopen("$filename", "a+"); //打开文件指针，创建文件 

			$pageURL = "http://";
		 
		  	if ($_SERVER["SERVER_PORT"] != "80") 
		  	{
		    	$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
		  	} 	
		  	else
		  	{
		    	$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
		  	}

			$msg = "Time:".date("Y-m-d H:i:s",time())."    IP:".$_SERVER["REMOTE_ADDR"]."     URL:".$pageURL;//."      Msg:".$msg;

			fwrite($fp,$msg."\r\n");
			fclose($fp); //关闭指针 
		}

		//日志文件切割
		private function cut(){
			$filename = $this->path.$this->filename;
			if(file_exists($filename)){
				if(filesize($filename) > $this->size){
					$bool = true;
					$i = 0;
					while ($bool) {
						$arr = explode(".", $this->filename);
						$refilename = $this->path.$arr[0]."_".$i.".".$arr[1];
						if(!file_exists($refilename)){
							rename($filename,$refilename);
							$bool = false;
						}
						$i++;
					}
				}
			}
		}
	}
?>