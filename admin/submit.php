<?php
include_once '../public/sql.php';
$pageSize = 30;
date_default_timezone_set('PRC');
if (isset($_POST['new'])) {
	# code...
	SESSION_start();
	$user_id = $_SESSION['userId'];
	$user_name = $_SESSION['userName'];
	$title=$_POST['title'];
	$content=mysql_escape_string($_POST['content']);
	$link=$_POST['link'];
	$link_code=$_POST['link_code'];
	$link_code2=$_POST['link_code2'];
	$time=date("Y-m-d");
    $cate=$_POST['cate'];
    $coer=$_POST['coer'];
    $sql="INSERT INTO `os` (`user_id`,`user_name`,`title`, `cate`, `coer`, `con`, `link`, `link_code`, `link_code2`, `time`)VALUES ('$user_id' ,'$user_name' ,'$title' ,'$cate' ,'$coer' ,'$content' ,'$link' ,'$link_code' ,'$link_code2' ,'$time')";
   /* $conn->autocommit(true);
    $sql = "INSERT INTO `os` (`user_id`,`user_name`,`title`, `cate`, `coer`, `con`, `link`, `link_code`, `link_code2`, `time`) VALUES(? ,? ,? ,? ,? ,? ,? ,? ,? ,?);";
    $stmt = $conn->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param($user_id,$user_name,$title,$cate,$coer,$content,$link,$link_code,$link_code2,$time);  */
    if(!$conn -> query($sql)){
		die("失败，请重试！");
	}else{
		die("I`m OK!");
	}
}
if (isset($_POST['edit'])) {
    $id = $_POST['edit'];
    $title=$_POST['title'];
    $content=mysql_escape_string($_POST['content']);
    $link=$_POST['link'];
    $link_code=$_POST['link_code'];
    $link_code2=$_POST['link_code2'];
    $sql = "UPDATE  `os` SET  `title` =  '$title', `con` = '$content', `link`='$link', `link_code`='$link_code', `link_code2`='$link_code2' WHERE  `id` = $id;";
    if(!$conn -> query($sql)){
        die("失败，请重试！".$sql);
    }else{
        die("I`m OK!");
    }
}
if (isset($_POST['selectCate'])) {
	# 返回所有分类...
	$sql="select * from class";
	$res= $conn->query($sql);
    while($info = $res->fetch_assoc()) {
        echo '<option value="'.$info['cate'].'">'.$info['cate'].'</option>';
    }
}

if (isset($_FILES['file'])) {
		$filename=explode('.',$_FILES['file']['name']);
		$name = $filename[0];
        $type = $filename[1];
        if($type <> 'jpg' || $type <> 'gif' || $type <> 'png'|| $type <> 'jpeg') $coer =null;
        $img=$_FILES['file']['tmp_name'];
        $wh=getimagesize($img);
        $wh_w=$wh[0];
        $wh_h=$wh[1];
        if($wh_w < $wh_h){
            $dst_w=268;
            $dst_h=379;
        }
        else{
            $dst_w=320;
            $dst_h=180;
        }
        $dst=imagecreatetruecolor($dst_w,$dst_h);
        $source=imagecreatefromjpeg($img);
        imagecopyresized($dst,$source,0,0,0,0,$dst_w,$dst_h,$wh_w,$wh_h);
        $un_name = uniqid("ACG58_").'_'.$name.'.'.$type;
        $coer='../images/avatar/'.$un_name;
        $info=array();
        $info['isSuccess'] = imagejpeg($dst,$coer,100);
        $info['filepath'] = $coer;
        $info['filename'] = $un_name;
        $info['w'] = $dst_w;
        $info['h'] = $dst_h;
        echo json_encode($info);  
    }
?>