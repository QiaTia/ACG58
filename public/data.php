<?php
include_once 'sql.php';
date_default_timezone_set('PRC');
/**
 * ░░░░░░░░░░░░░░░░░░░░░░░░▄░░
 * ░░░░░░░░░▐█░░░░░░░░░░░▄▀▒▌░
 * ░░░░░░░░▐▀▒█░░░░░░░░▄▀▒▒▒▐
 * ░░░░░░░▐▄▀▒▒▀▀▀▀▄▄▄▀▒▒▒▒▒▐
 * ░░░░░▄▄▀▒░▒▒▒▒▒▒▒▒▒█▒▒▄█▒▐
 * ░░░▄▀▒▒▒░░░▒▒▒░░░▒▒▒▀██▀▒▌
 * ░░▐▒▒▒▄▄▒▒▒▒░░░▒▒▒▒▒▒▒▀▄▒▒
 * ░░▌░░▌█▀▒▒▒▒▒▄▀█▄▒▒▒▒▒▒▒█▒▐
 * ░▐░░░▒▒▒▒▒▒▒▒▌██▀▒▒░░░▒▒▒▀▄
 * ░▌░▒▄██▄▒▒▒▒▒▒▒▒▒░░░░░░▒▒▒▒
 * ▀▒▀▐▄█▄█▌▄░▀▒▒░░░░░░░░░░▒▒▒
 * 单身狗就这样默默地看着你，一句话也不说。
 */

function dataTo($data){
	# code...
	switch ($data) {
		case ($data > 0 && $data < 7):
			return $data.'天';
			break;
		case ($data >= 7 && $data < 30):
			return round($data/7).'周';
			break;
		case ($data >= 30 && $data < 356):
			return round($data/30).'月';
			break;
		case ($data >= 356):
			return round($data/356).'年';
			break;
			break;
		default:
			return $data.'天';
			break;
	}
}
function sqlSelect($tableName,$option,$val){
	$conn = new mysqli($GLOBALS['serverhost'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['dbname']);
	$conn->set_charset("utf8");
	if($option =='') $option='id';
	if ($conn->connect_error) {
		return "连接失败: " . $conn->connect_error;
	} 
	if($val != '') $sql = "SELECT * FROM `$tableName` WHERE `$option`='$val'";
	else $sql = "SELECT * FROM `$tableName`";
	$result = $conn->query($sql);
	return $result->fetch_assoc();
}
function sqlNum($tableName,$option,$val){
	$conn = new mysqli($GLOBALS['serverhost'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['dbname']);
	$conn->set_charset("utf8");
	if($option != '') $sql = "SELECT * FROM `$tableName` WHERE `".$option."` = '$val'";
	else $sql = "SELECT * FROM `$tableName`";
	$result = $conn->query($sql);
	return $result->num_rows;
}
function sqlUpdate($tableName,$option,$val,$id){
	$conn = new mysqli($GLOBALS['serverhost'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['dbname']);
	$conn->set_charset("utf8");
	$sql = "UPDATE  `$tableName` SET  `$option` =  '$val' WHERE  `id` =$id;";
	return $conn->query($sql);
}
function sqlDel($tableName,$id){
	$conn = new mysqli($GLOBALS['serverhost'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['dbname']);
	$conn->set_charset("utf8");
	$sql = "DELETE FROM `$tableName` WHERE  `id` =$id;";
	return $conn->query($sql);
}
function send_post($url, $post_data) {  
  
  $postdata = http_build_query($post_data);  
  $options = array(  
    'http' => array(  
      'method' => 'POST',  
      'header' => 'Content-type:application/x-www-form-urlencoded',  
      'content' => $postdata,  
      'timeout' => 15 * 60 // 超时时间（单位:s）  
    )  
  );  
  $context = stream_context_create($options);  
  $result = file_get_contents($url, false, $context);  
  
  return $result;  
}
?>