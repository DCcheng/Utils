<?php
	class Payment{

		public $model = "";
		//初始化支付类
		public static function init($model){
			$model = strtolower($model);
			require_once($model."/".$model.".php");

			$payment = new Payment();
			$payment->model = new $model();
			return $payment;
		}

		//获取支付代码
		public function getHtml($out_trade_no,$subject,$total_fee){
			return $this->model->get($out_trade_no,$subject,$total_fee);
		}

		//获取支付代码
		public function notify(){
			return $this->model->notify();
		}
	}
?>