<?php
	$serverhost = 'localhost';
	$dbname = "acg";
	$username = "root";
	$password = "usbw";
	$conn = new mysqli($serverhost,$username,$password,$dbname);
	// 检测连接
	if ($conn->connect_error) {
		die("连接失败: " . $conn->connect_error);
	} 
	$conn->set_charset("utf8");
?>