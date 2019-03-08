<?php

	class PaymentUtils{

		public $model = "";
		// public static $Obj = null;
		//初始化支付类
		public function setModel($model){
			$model = strtolower($model);
			if(!isset($this->model[$model])){
				include_once dirname(__FILE__)."/payment/".$model."/".$model.".php";
				$this->model[$model] = new $model();
			}
			return $this->model[$model];
		}

		//获取支付代码
		public function getHtml($model,$out_trade_no,$subject,$total_fee){
			return $this->setModel($model)->get($out_trade_no,$subject,$total_fee);
		}

		//获取支付代码
		public function notify($model){
			return $this->setModel($model)->notify();
		}
	}
?>