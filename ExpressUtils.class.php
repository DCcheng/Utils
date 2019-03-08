<?php
include_once dirname(__FILE__)."/CurlUtils.class.php";
class ExpressUtils{

	public function get($typeNu,$typeCom){
		
		$typeCom = $this->getTypeCom($typeCom);
		$AppKey='29833628d495d7a5';
		$url ='http://api.kuaidi100.com/api?id='.$AppKey.'&com='.$typeCom.'&nu='.$typeNu.'&show=0&muti=1&order=desc';

		$curl = new CurlUtils();
		$curl->ssl = false;
		$get_content = $curl->get($url);
		// //优先使用curl模式发送数据
		// $curl = curl_init();
		// curl_setopt ($curl, CURLOPT_URL, $url);
		// curl_setopt ($curl, CURLOPT_HEADER,0);
		// curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
		// curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
		// curl_setopt ($curl, CURLOPT_TIMEOUT,5);
		// $get_content = curl_exec($curl);
		// curl_close ($curl);
		if($get_content){
			return $get_content;
		}else{
			return json_encode(array("message"=>"请求失败","status"=>0));
		}
		exit();
	}

	public function getTypeCom($typeCom){
		switch ($typeCom){
			case "EMS"://ecshop后台中显示的快递公司名称
				$typeCom = 'ems';//快递公司代码
				break;
			case "中国邮政":
				$typeCom = 'ems';
				break;
			case "申通快递":
				$typeCom = 'shentong';
				break;
			case "圆通速递":
				$typeCom = 'yuantong';
				break;
			case "顺丰速运":
				$typeCom = 'shunfeng';
				break;
			case "天天快递":
				$typeCom = 'tiantian';
				break;
			case "韵达快递":
				$typeCom = 'yunda';
				break;
			case "中通速递":
				$typeCom = 'zhongtong';
				break;
			case "龙邦物流":
				$typeCom = 'longbanwuliu';
				break;
			case "宅急送":
				$typeCom = 'zhaijisong';
				break;
			case "全一快递":
				$typeCom = 'quanyikuaidi';
				break;
			case "汇通快递":
				$typeCom = 'huitongkuaidi';
				break;	
			case "民航快递":
				$typeCom = 'minghangkuaidi';
				break;	
			case "亚风速递":
				$typeCom = 'yafengsudi';
				break;	
			case "快捷速递":
				$typeCom = 'kuaijiesudi';
				break;	
			case "华宇物流":
				$typeCom = 'tiandihuayu';
				break;	
			case "中铁快运":
				$typeCom = 'zhongtiewuliu';
				break;		
			case "FedEx":
				$typeCom = 'fedex';
				break;		
			case "UPS":
				$typeCom = 'ups';
				break;		
			case "DHL":
				$typeCom = 'dhl';
				break;		
			default:
				$typeCom = '';
		}
		return $typeCom;
	}
}



?>
