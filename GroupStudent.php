<?php
	
/**
* 作者：DC
* 时间：2019年3月8日14:48:04
* 需求：选课系统的需要，对所选课程的学生进行位置安排，要求每个学生的前后左右都不能是同专业的，学生的专业数以及科室大小都不固定
* 测试：暂定了A、B、C、D、E五个专业的学生，另外定义了一个10行10列的教室作为测试。
*/

/**
 * GroupStudent
 * 实现学生排序算法
 */
class GroupStudent
{
	public $arr,$arrNum;
	public function __construct($arr,$arrNum){
		$this->arr = $arr;
		$this->arrNum = $arrNum;
	}
	public function setStudent($student_arr,$row,$col){
		$prev = ($col > 0)?substr($student_arr[$row][$col - 1],0,1):"";
		$top = ($row > 0)?substr($student_arr[$row - 1][$col],0,1):"";
		$Num = $this->arrNum;
		$student = "";
		if($top == $prev)unset($Num[$top]);
		else unset($Num[$top],$Num[$prev]);
		if(count($Num) > 0){
			$key = array_search(max($Num),$Num);
			$student = $this->arr[$key][0]; 
			array_splice($this->arr[$key],0,1);
			$this->arrNum[$key]--;
			if($this->arrNum[$key] == 0)unset($this->arrNum[$key]);
		}
		return $student;
	}
}

/**
 * 随机选课的学生，以及每个专业对应的学生数
 */
	function setGroupStudent($label){
		$arr = array();
		$num = rand(10, 20);
		for($i = 0;$num >= $i;$i++){
			$arr[$i] = $label.$i;
		}
		return $arr;
	}

	echo "<pre>";
	$arr["A"] = setGroupStudent("A");
	$arr["B"] = setGroupStudent("B");
	$arr["C"] = setGroupStudent("C");
	$arr["D"] = setGroupStudent("D");
	$arr["E"] = setGroupStudent("E");
	$arrNum = array("A"=>count($arr["A"]),"B"=>count($arr["B"]),"C"=>count($arr["C"]),"D"=>count($arr["D"]),"E"=>count($arr["E"]));
/**
 * 结束随机学生
 */

/**
 * 学生分配测试
 */
	$start_time = microtime();
	echo "start.....";
	$student_arr = array();
	$obj = new GroupStudent($arr,$arrNum);
	echo "<table border='1' style='text-align: center;'>";
	for($i = 0 ; $i < 10;$i++){
		echo "<tr>";
		for ($j=0; $j < 10; $j++) { 
			$student_arr[$i][$j] = $obj->setStudent($student_arr,$i,$j);
			echo "<td>".$student_arr[$i][$j]."</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
	echo "end.....";
	echo (microtime() - $start_time)*1000;

?>