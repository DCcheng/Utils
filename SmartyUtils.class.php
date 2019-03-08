<?php
	/**
	* 类名：EmailUtils
	* 作用：邮件发送工具类
	* 作者：DC
	* 时间：2015年8月27日 11:36:09
	* 版本：v1.0
	*/
	include_once dirname(__FILE__)."/smarty/Smarty.class.php";
	class SmartyUtils
	{
		private $smarty;
		public	function __construct(){
			$this->smarty = new Smarty(); //建立邮件发送类
		}

		public function setConfig($root){
			$this->smarty->template_dir = $root."/templates/"; //模板目录
			$this->smarty->compile_dir = $root."/runtimes/compiles/"; //模板缓存目录
			$this->smarty->cache_dir = $root."/runtimes/caches/"; //模板缓存目录
			$this->smarty->left_delimiter = "{{"; //模板缓存目录
			$this->smarty->right_delimiter = "}}"; //模板缓存目录
			return $this->smarty;
		}

	}
?>