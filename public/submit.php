<?php
include_once 'sql.php';
$pageSize = 30;
date_default_timezone_set('PRC');
/*
*前台收藏
*需要POST传入 fav conId
*返回  数据
*/
if(isset($_POST['fav'])){
	$conId = $_POST['conId'];
	session_start();
	$push = '0';
	if(!isset($_SESSION['userId'])) die("请先登录");
	$userId = $_SESSION['userId'];
	$favearray = $conn->query("SELECT * FROM  `os`  WHERE `id` = '$conId'")->fetch_assoc()['fav'];
	$i = $favearray?explode(',',$favearray):array();
	if(!in_array($userId,$i)) array_push($i,$userId);
	else{ $push = '1'; 
		foreach ($i as $key=>$value){
				if ($value == $userId){
					unset($i[$key]);
				}
			}
	}
	$i = implode(',',$i);
	$sql="UPDATE `os` SET `fav` = '$i' WHERE `id` = '$conId'";
	$conn->query($sql);
	$favearray = $conn->query("SELECT * FROM  `user`  WHERE `id` = '$userId'")->fetch_assoc()['fav'];
	$i = $favearray?explode(',',$favearray):array();
	if($push!='1') array_push($i,$conId);
	else{
		foreach ($i as $key=>$value){
			if ($value == $conId){
				unset($i[$key]);
			}
		}
	}
	$i = implode(',',$i);
	$sql="UPDATE `user` SET `fav` = '$i' WHERE `id` = '$userId'";
	$conn->query($sql);
	die($push);
}
/*
*前台赞帖子
*需要POST传入 like conId
*返回  数据
*/
if(isset($_POST['like'])){
	$conId = $_POST['conId'];
	session_start();
	if(!isset($_SESSION['userId'])) die("请先登录");
	$likearray = $conn->query("SELECT * FROM  `os`  WHERE `id` = '$conId'")->fetch_assoc()['cool'];
	//print_r($likearray);
	$i = $likearray?explode(',',$likearray):array();
	array_push($i,$_SESSION['userId']);
	//print_r($i);
	$i = implode(',',$i);
	$sql="UPDATE `os` SET `cool` = '$i' WHERE `id` = '$conId'";
	$conn->query($sql);
	die(0);
}
/*
*帖子回复功能实现
*需要POST传入 reply conId
*返回  数据
*/
if(isset($_POST['reply'])){
	$conId = $_POST['conId'];
	$reply = $_POST['reply'];
	session_start();
	if(!isset($_SESSION['userId'])) die("请先登录");
	if($reply=='') die('请输入回复内容');
	$userId = $_SESSION['userId'];
	$time = date("Y-m-d H:i:s",time());

	$sql = "INSERT INTO `reply` (`userid`, `conid`, `con`, `time`) VALUES ('$userId', '$conId', '$reply', '$time');";
	if(!$conn->query($sql)) die("失败，请重试");
	else die('0');
}
/*
*帖子回复功能实现
*需要POST传入 reply conId
*返回  数据
*/
if(isset($_POST['navUser'])){
	session_start();
	if(!isset($_SESSION['userId'])) die('<li><a href="javascript:searchShow();"><i class="mdui-icon material-icons">&#xe8b6;</i></a></li><li><a href="./user/Login.html">登陆</a></li>');
	$userId = $_SESSION['userId'];
	$sql = "SELECT * FROM  `user` WHERE `id` = '$userId';";
	$info = $conn->query($sql)->fetch_assoc();
	echo '<li><a href="javascript:searchShow();"><i class="mdui-icon material-icons">&#xe8b6;</i></a></li>
	<li class="dropdown"><a href="javascript:;">'.$info['name'].'<i class="mdui-icon material-icons">&#xe5c5;</i></a>
	<ul class="dropdown-meun">
		<li><a href="./admin/new.html">我要分享</a></li>
		<li><a href="./user">我的空间</a></li>
		<li><a href="./admin/?rame=content">我的帖子</a></li>
		<li><a href="./admin/?rame=reply">我的吐槽</a></li>
		<li><a href="./admin/?rame=setting">我的设置</a></li>
		<li><a href="./?exit">退出登陆</a></li>
	</ul>
	</li>';
}
/*
*前台获取回复内容
*需要POST传入 conId page
*返回 html 数据
*/
if(isset($_POST['page'])){
	$id = $_POST['conId'];
	$page = isset($_POST['page'])?$_POST['page']:0;
	$sql="select * from reply where conid = $id LIMIT $page , 10";//查询表 10代表没行10条记录
	$i = 0;
	$res= $conn->query($sql);
	while($info = $res->fetch_assoc()){
		$i++;
		$userid = $info['userid']; $rest = $conn->query("select * from `user` where id = $userid")->fetch_assoc();
		?>
	<li class="mdui-list-item mdui-ripple">
	 	<div class="mdui-list-item-avatar"><img style="width: 40px; height: 40px;" src="images/user/<?php echo $rest['coer']?>"></div>
	 	<div class="mdui-list-item-content">
	 		<div class="mdui-list-item-title">
	 			<a href="javascript;"><?php echo $rest['name'];?></a>
	 		</div>
	 		<div class="mdui-list-item-text mdui-typo">
	 			<p class="mdui-typo">
	 				<?php echo $info['con'];?>
	 			</p>
	 		</div>
	 		<div class="mdui-list-item-text">
	 			<?php echo $info['time'];?>
	 		</div>
	 	</div>
	</li>
	<li class="mdui-divider-inset mdui-m-y-0"></li>
	<?php
	}
	if(!$i)die('<h3 style="line-height:75px; height:75px;" align="center">还没人来评论哎，快来抢沙发吧</h3>');
}
?>