<?php
	/**
	* 类名：RandomUtils
	* 作用：生成随机字符串工具类
	* 作者：DC
	* 时间：2015年11月2日 14:42:42
	* 版本：v1.0
	*/
	if(!isset($_SESSION)){ session_start(); }
	class CodeUtils
	{
		public $CodeUtils_Img = "";
		public $CodeUtils_Code = "";
		public function __construct(){}

		//type = 1 只是数字
		//type = 2 数字跟大写字母
		//type = 3 数字大小写字母
		private function setNormal($length = 4,$type = 2){
			$str = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
			$random = "";
			switch ($type) {
				case '1':
					$start = 0;
					$end = 9;
					break;
				case '2':
					$start = 0;
					$end = 35;
					break;
				default:
					$start = 0;
					$end = 61;
					break;
			}
			for ($i=0; $i < $length; $i++) { 
				 $index = rand($start,$end);
				 $random .= substr($str,$index,1);
			}
			$_SESSION['CodeUtils_Img'] = $random;
			$_SESSION['CodeUtils_Code'] = $random;
		}

		//获取计算题验证码
		public function setCalculate(){
			$first = array(20,19,18,17,16,15,14,13,12,11,10);
			$operator = array("+","-","*","/");
			$end = array(10,9,8,7,6,5,4,3,2,1);
			$str = $first[rand(0,10)].$operator[rand(0,2)].$end[rand(0,9)];
			$_SESSION['CodeUtils_Img'] = $str;
			$_SESSION['CodeUtils_Code'] = eval("return $str;");
		}

		//获取常规验证码
		public function set($type = 2){
			switch ($type) {
				case '1':
					$this->setNormal();
					break;
				case '2':
					$this->setCalculate();
					break;
				default:
					$this->setNormal();
					break;
			}
			return $this;
		}

		public function get(){
			return $_SESSION['CodeUtils_Code'];
		}

		public function verify($str){
			$this->set();
			if($str == $this->get()){
				return true;
			}else{
				return false;
			}
		}

		public function clean(){
			$this->set();
		}

		public function getCodeImg(){
			header ( 'Content-type: image/png' );
	        //创建图片
	        $im = imagecreate($x=130,$y=45 );
	        $bg = imagecolorallocate($im,0,0,0); //第一次对 imagecolorallocate() 的调用会给基于调色板的图像填充背景色
	        $fontColor = imageColorAllocate ( $im, 255, 255, 255 );   //字体颜色
	        imagettftext($im,30,0,15,35,$fontColor,dirname(__FILE__)."/fonts/DS-DIGII.TTF",$_SESSION['CodeUtils_Img']);

	        // //干扰线
	        // for ($i=0;$i<8;$i++){
	        //         $lineColor        = imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
	        //         imageline ($im,rand(0,$x),0,rand(0,$x),$y,$lineColor);
	        // }
	        // 干扰点
	        // for ($i=0;$i<250;$i++){
	        //         imagesetpixel($im,rand(0,$x),rand(0,$y),$fontColor);
	        // }
	        imagepng($im);
	        imagedestroy($im);                
		}
	}
?>