<?php
	/**
	* 类名：EmailUtils
	* 作用：邮件发送工具类
	* 作者：DC
	* 时间：2015年8月27日 11:36:09
	* 版本：v1.0
	*/
	include_once dirname(__FILE__)."/email/PHPMailer.php";
	class EmailUtils
	{
		private $mail;
		private $is_setSMTP = false;

		public	function __construct(){
			$this->mail = new PHPMailer(); //建立邮件发送类
		}

		//设置SMTP服务器
		public function setSMTP($username,$password,$host,$port = 25,$is_html = true){
			$this->mail->IsSMTP(); // 使用SMTP方式发送
			$this->mail->SMTPSecure = 'ssl';
			$this->mail->CharSet = "UTF-8";
			$this->mail->Host = $host; // 您的企业邮局域名
			$this->mail->SMTPAuth = true; // 启用SMTP验证功能
			$this->mail->Username = $username; // 邮局用户名(请填写完整的email地址)
			$this->mail->Password = $password; // 邮局密码
			$this->mail->Port= $port;
			$this->mail->From = $username; //邮件发送者email地址
			$this->mail->FromName = $username;
			$this->mail->IsHTML($is_html);
			$this->is_setSMTP = true;
			$this->CharSet = "UTF-8";
			return $this;
		}

		private function getConfig(){
			$config = require_once(dirname(__FILE__)."/email/EmailConfig.php");
			$this->setSMTP($config['username'],$config['password'],$config['host'],$config['port'],$config['is_html']);
		}

		public function setAttachment($path = ""){
		    $arr = explode(".",$path);
            $this->mail->AddAttachment(dirname(__FILE__)."/../..".$path,'附件.'.$arr['1']);
            return $this;
        }
		//发送邮件
		public function send($target_address,$title,$message){

			//如果没有实例化配置，则直接调用配置文件的参数进行SMTP的配置
			if($this->is_setSMTP == false){
				$this->getConfig();
			}

			$this->mail->AddAddress("$target_address", "$target_address");//收件人地址，可以替换成任何想要接收邮件的email信箱,格式是AddAddress("收件人email","收件人姓名")
			$this->mail->Subject = $title; //邮件标题
			$this->mail->Body = $message; 
			$result = $this->mail->Send();
			return $result;
		}
	}
?>