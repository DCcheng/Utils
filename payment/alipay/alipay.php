<?php
	require_once(dirname(__FILE__).'/../PaymentInterface.php');
	require_once('alipay.config.php');
	require_once('AlipaySubmit.php');
	require_once('AlipayNotify.php');
	require_once(dirname(__FILE__).'/../NotifyAction.php');
	
	class alipay implements PaymentInterface{

		public $alipay_config;

		public function __construct(){
			$this->alipay_config = alipayConfig::get();
		}

		public function get($out_trade_no,$subject,$total_fee){

			$alipay_config = $this->alipay_config;

		    $alipaySubmit = new AlipaySubmit($alipay_config);
			return $alipaySubmit->buildRequestForm(
				array(
					"service" => $alipay_config['service'],
					"partner" => trim($alipay_config['partner']),
					"payment_type"	=> $alipay_config['payment_type'],
					"return_url"	=> $alipay_config['return_url'],			
					"seller_email"	=> $alipay_config['seller_email'],
					"out_trade_no"	=> $out_trade_no,
					"subject"	=> $subject,
					"total_fee"	=> $total_fee,
					"_input_charset"	=> trim($alipay_config['input_charset'])
				),"get", "确认");
		}

		//这里执行操作
		public function notify(){
			$alipayNotify = new AlipayNotify($this->alipay_config);
			$verify_result = $alipayNotify->verifyNotify();
			if($verify_result) {//验证成功
				$out_trade_no = $_POST['out_trade_no'];
				//这里执行操作
				NotifyAction::updateOrder($out_trade_no);
				
				echo "success";		//请不要修改或删除
			}else{
				echo "fail";
			}
		}
	}
?>