<?php
if(isset($_REQUEST['file'])){
	$file = $_REQUEST["file"];
	if(file_exists($file)){
		echo '文件存在,可以删了';
	} else {
		echo '猪,文件不存在,可能路径添错了';
	}
	if(!unlink(iconv('gb2312','utf-8','$file')))
		die("Erro! ".$file." ");
}
?>