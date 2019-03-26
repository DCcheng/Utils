<?php
namespace common\component;
/**
 * Class TokenComponent
 * @package common\component
 * Token 项目代码 1000
 * Token 流水号：00
 * 错误代码=项目代码+流水号（如100000，前4位为项目代码，后两位为流水号）
 */
class TokenComponent
{
	/**
	 * [$configArr 工具配置数组]
	 * @var array
	 */
    private $configArr = array(
    	"c"=>"chr",
    	"key"=>"gZ7v81FWTdWc0vS!",
    	"s"=>"sha256",
    	"path"=>"token",
    	"exp"=>3600
    );

    /**
     * [$token 访问令牌]
     * @var [string]
     */
    private $token = "";

    /**
     * [$file 临时文件存放路径]
     * @var [string]
     */
    private $file = "";

    /**
     * [createToken 用于创建Token操作]
     * @param  [array] $payload [需要记录的信息，一般存储用户ID等]
     * @return [array]          [接口返回数据，ret：状态字段，0-失败，1-成功。msg：操作返回信息描述。data：包含的数据]
     */
    public function createToken($payload){
        $payload = json_encode($this->setPayload($payload));
        $this->token = $this->getSign(base64_encode($payload));
        $file = $this->configArr["path"]."/".$this->token;
        file_put_contents($file,$payload);
        return array("ret"=>1,"msg"=>"更新成功","data"=>array("token"=>$this->token));
    }

    /**
     * [validateTokenReturnArray 用于验证Token的有效性]
     * @param  [string] $returnDataType [需要返回数据的类型]
     * @return [array]          [接口返回数据，ret：状态字段，0-失败，1-成功。msg：操作返回信息描述。data：包含的数据]
     * @return [bool]          [接口返回数据，true OR false]
     */
    public function validateToken($returnDataType = "array"){
    	if(isset($_SERVER["HTTP_AUTHORIZATION"])){
    		$this->token = $_SERVER["HTTP_AUTHORIZATION"];
    	}
        $this->file = $this->configArr["path"]."/".$this->token;
        if(file_exists($this->file) && $this->token != ""){
            $json = json_decode(file_get_contents($this->file),true);
            if($json["exp"] > time()){
                return $returnDataType == "bool"?true:array("ret"=>1,"msg"=>"校验成功","data"=>$json);
            }else{
            	unlink($this->file);
                return $returnDataType == "bool"?false:array("ret"=>"100000","msg"=>"Token已经过期，请重新申请");
            }
        }else{
            return $returnDataType == "bool"?false:array("ret"=>"100001","msg"=>"无效的Token，请重新核对令牌准确性");
        }
    }

    /**
     * [invalidateToken 销毁令牌信息]
     * @return [array]        [接口返回数据，ret：状态字段，0-失败，1-成功。msg：操作返回信息描述。data：包含的数据]
     */
    public function invalidateToken(){
        $result = $this->validateToken();
        if($result["ret"] == 1){
            unlink($this->file);
            return array("ret"=>1,"msg"=>"取消Token成功");
        }else{
        	return $result;
        }
    }

    /**
     * [refreshToken 刷新令牌信息]
     * @param  [string] $token [用户访问令牌]
     * @return [array]        [接口返回数据，ret：状态字段，0-失败，1-成功。msg：操作返回信息描述。data：包含的数据]
     */
    public function refreshToken(){
        $result = $this->validateToken();
        if($result["ret"] == 1){
            unlink($this->file);
            return $this->createToken($result["data"]);
        }else{
            return $result;
        }
    }

    /**
     * [getSign description]
     * @param  [string] $str [传入字符串]
     * @return [string]      [加密令牌]
     */
    private function getSign($str){
        $c = $this->configArr["c"];
        $ss = $c(104).$c(97).$c(115).$c(104);
        $sign = base64_encode($ss($this->configArr["s"],$str.$this->configArr["key"]));
        return $sign;
    }

    /**
     * [setPayload 设置Token有效时间]
     * @param [array] $payload [传入消息体数组]
     * @return [array] $payload     [加入有效时间的消息体数组]
     */
    private function setPayload($payload){
        $time = time() + $this->configArr["exp"];
        $payload = array_merge($payload,array("exp"=>$time));
        return $payload;
    }
} 


header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');
header('Access-Control-Allow-headers:x-requested-with,Authorization,Content-Type');
// if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
//     echo 1;
//     die();
// }
// echo $_SERVER['REQUEST_METHOD'];
// die();
// header('Access-Control-Max-Age:36000');
$obj = new TokenComponent();
// $obj->createToken(["ID"=>"sdfsdfwerzxcvsdf"]);
echo json_encode($obj->validateToken());
?>