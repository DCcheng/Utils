<?php
	interface PaymentInterface{

		//获取支付代码
		public function get($out_trade_no,$subject,$total_fee);

		//获取支付代码
		public function notify();
	}
?>