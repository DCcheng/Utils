<?php
	require_once(dirname(__FILE__).'/../PaymentInterface.php');
	require_once('lib/WxPay.Api.php');
	require_once('WxPay.NativePay.php');
	require_once('WxPay.PayNotifyCallBack.php');
	class wxpay implements PaymentInterface{

		public function get($out_trade_no,$subject,$total_fee){
		    //生成二维码
		    $notify = new NativePay();
		    $input = new WxPayUnifiedOrder();
		    $input->SetBody($subject);
		    $input->SetOut_trade_no($out_trade_no);
		    $input->SetTotal_fee((int)($total_fee * 100));
		    //二维码有效时间为10分钟
		    $input->SetTime_start(date("YmdHis"));
		    $input->SetTime_expire(date("YmdHis", time() + 600));
		    $input->SetNotify_url('http://www.ewondfo.com/notify.php');
		    $input->SetTrade_type("NATIVE");
		    $input->SetProduct_id($out_trade_no);
		    $result = $notify->GetPayUrl($input);
		    var_dump($result);
		    $url2 = $result["code_url"];
		    $def_url = '<img alt="微信扫码支付" src="http://paysdk.weixin.qq.com/example/qrcode.php?data='.urlencode($url2).'" style="width:150px;height:150px;"/>';
		    return $def_url;
		}

		public function notify(){
			$notify = new PayNotifyCallBack();
			$notify->Handle(false);
		}
	}
?>