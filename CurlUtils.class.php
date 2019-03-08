<?php
	/**
	* 类名：CurlUtils
	* 作用：网络请求工具类
	* 作者：DC
	* 时间：2015年8月27日 11:09:40
	* 版本：v1.0
	*/
	class CurlUtils
	{
		private $ssl = false;
		//设置请求头
		// public function setHeader($header){
			// $this->header = $header;
			// $header = array ( 
			// "POST {$path}?{$query} HTTP/1.1", 
			// "Host: {$temp['host']}", 
			// "Content-Type: text/xml; charset=utf-8", 
			// 'Accept: */*', 
			// "Referer: http://{$temp['host']}/", 
			// 'User-Agent: Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; SV1)', 
			// "X-Forwarded-For: {$myIp}", 
			// "Content-length: 380", 
			// "Connection: Close" 
			// ); 
		// }
		
		public function __call($method,$arg){
			$this->$method($arg);
			return $this;
		}

		public function __set($key,$value){
			$this->$key = $value;
		}

		public function __get($key){
			return $this->$key;		
		}

		//开启https协议验证
		private function setSSL(){
			$this->ssl = true;
		}

		//触发get请求
		public function get($url,$header = array()){
			return $this->send($url,array(),"get",$header);
		}

		//触发post请求
		public function post($url,$data = array(),$header = array()){
			return $this->send($url,$data,"post",$header);
		}

		//发送模拟数据包
		private function send($url,$data = array(),$method = "get",$header = array()){

			$ch = curl_init ();
			curl_setopt ( $ch, CURLOPT_URL, $url );
			
			if($this->ssl){
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
    		}
		    
		    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
		    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
		    curl_setopt($ch, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
		    curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
		    curl_setopt($ch, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式

			if(is_array($header)&&count($header) > 0){
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header); //设置头信息的地方 
			}

			if($method == "post"){
				curl_setopt($ch, CURLOPT_POST, 1); // 发送一个常规的Post请求
				if(is_array($data)&&count($data) > 0){
					curl_setopt ( $ch, CURLOPT_POSTFIELDS, json_encode($data) );
				}
			}
			
			$result = curl_exec ( $ch );
			return $result;
		}
	}
?>