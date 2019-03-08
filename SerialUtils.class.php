<?php
/**
 * Created by PhpStorm.
 * User: DC
 * Date: 2017/8/22
 * Time: 10:00
 */


class SerialUtils
{
    public $code = "";
    public $file = "";
    public $filename = "";
    public $model = "Y";
    public $lenght = 4;
    public $str = "";
    public $prefix = "WF";

    public function set(){
        file_put_contents($this->file,$this->str);
    }

    public function get($code){
        $this->code = $code;
        $this->filename = $this->prefix.$code;
        $this->file = dirname(__FILE__)."/serial/".$this->filename.".php";
        if(!file_exists($this->file)) {
            $str = $this->setStr(0);
            file_put_contents($this->file,$str);
        }

        $data = include_once($this->file);
        if ($data["date"] !== date($this->model)){
            $this->str = $this->setStr();
            $code = date($this->model)."-".$this->code."-".str_pad("1",$this->lenght,'0',STR_PAD_LEFT);
        }else{
            $number = $data['number'] + 1;
            $this->str = $this->setStr($number);
            $code = $data['date']."-".$this->code."-".str_pad($number,$this->lenght,'0',STR_PAD_LEFT);
        }
        return $code;
    }

    private function setStr($number = 1){
        $str = "<?php return ['date'=>'".date($this->model)."',";
        $number = str_pad($number,$this->lenght,'0',STR_PAD_LEFT);
        $str .= "'number'=>'".$number."']; ?>";
        return $str;
    }
}