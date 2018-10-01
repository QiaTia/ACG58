<?php
include_once '../../public/data.php';
if(isset($_GET['new'])){
	//code~
	$title = $_GET['title'];
	$imgSrc = $_GET['img'];
	$href = $_GET['href'];
	$sql = "INSERT INTO `banner` (`title` ,`img-src` ,`href`)VALUES ('$title',  '$imgSrc',  '$href');";
	if(!$conn->query($sql)) die('失败,请重试'.$sql);
	else die('成功！');
}if(isset($_GET['edit'])){
	//code~
	$i = $_GET['edit'];
	$title = $_GET['title'];
	$imgSrc = $_GET['img'];
	$href = $_GET['href'];
	$sql = "UPDATE `banner` SET  `title` =  '$title', `img-src` = '$imgSrc', `href` = '$href' WHERE  `id` =$i;";
	if(!$conn->query($sql)) die('失败,请重试');
	else die('成功！');
}
?>