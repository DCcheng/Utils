<?php
require_once ("lib/WxPay.Api.php");
require_once ('lib/WxPay.Notify.php');
require_once (dirname(__FILE__).'/../NotifyAction.php');

class PayNotifyCallBack extends WxPayNotify
{
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{	
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}

		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		if(array_key_exists("return_code", $result) && array_key_exists("result_code", $result) && $result["return_code"] == "SUCCESS" && $result["result_code"] == "SUCCESS")
		{
			// NotifyAction::updateOrder($result['out_trade_no']);
			return true;
		}
		return false;
	}
}
?>