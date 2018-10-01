<?php
include_once '../public/sql.php';
include_once '../public/data.php';
$pageSize = 30;
date_default_timezone_set('PRC');

/*
*前台获取用户信息
*需要POST传入 user
*返回 jsonp 数据
*/
if(isset($_POST['userInfo'])){
	SESSION_start();
	$id = !empty($_POST['user'])?$_POST['user']:$_SESSION['userId'];
	$info = sqlSelect('user','id',$id);
	unset($info['pw']);
	//$info['pw'] = '这个不该看到的';
	if($info == '') $info['name'] = '没有这个哥们哎！';
	print_r(json_encode($info));
}
/*
*前台获取用户信息
*需要POST传入 tableCate
*返回 jsonp 数据
*/
if(isset($_POST['tableCate'])){
	$tableCate = $_POST['tableCate'];
	$page = isset($_POST['page'])?$_POST['page']:1;
	SESSION_start();
	$id = !empty($_POST['user'])?$_POST['user']:$_SESSION['userId'];
	$user = sqlSelect('user','id',$id);
	switch ($tableCate) {
		case 'info':
			# 用户详细信息查询...
			$info = $user;
			$info['login_date']=dataTo(intval((strtotime("now") - strtotime($info['login_date']))/86400)).'前('.$info['login_date'].')';
			$info['date']=dataTo(intval((strtotime("now") - strtotime($info['date']))/86400)).'前('.$info['date'].')';
			$info['authorNum'] = sqlNum('os','user_id',$id);
			$info['replyNum'] = sqlNum('reply','userid',$id);
			$info['followersNum']=null;
			$info['fansNum']=null;
	echo <<<EOT
			<table class="layui-table">
				<tr>
	          		<td>用户名：</td>
	          		<td>{$info["name"]}</td>
	          	</tr>
	          	<tr>
	          		<td>用户ID：</td>
	          		<td>{$info["id"]}</td>
	          	</tr>
	          	<tr>
	          		<td>用户注册时间：</td>
	          		<td>{$info["date"]}</td>
	          	</tr>
	          	<tr>
	          		<td>用户最后登录时间：</td>
	          		<td>{$info["login_date"]}</td>
	          	</tr>
	          	<tr>
	          		<td>文章数量</td>
	          		<td>{$info['authorNum']}</td>
	          	</tr>
	          	<tr>
	          		<td>评论数量</td>
	          		<td>{$info['replyNum']}</td>
	          	</tr>
	          	<tr>
	          		<td>关注数量</td>
	          		<td>{$info['followersNum']}</td>
	          	</tr>
	          	<tr>
	          		<td>粉丝数量</td>
	          		<td>{$info['fansNum']}</td>
	          	</tr>
			</table>
EOT;
			break;
	case 'followers':
			# 用户关注查询...
		echo <<<EOT
			<table class="layui-table">
				<tr>
	          		<td colspan="2">正在努力中~~~</td>
	          	</tr>
	        </table>
EOT;
			break;
	case 'author':
			# 用户发表文章遍历...
			$allNum=ceil(sqlNum('os','user_id',$id) / $pageSize);
			$limit = ($page-1) * $pageSize;
			$sql = "SELECT * FROM  `os` WHERE `user_id` = '$id' LIMIT $limit, $pageSize;";
			$res = $conn->query($sql);
			$i=0;
			echo '<table class="layui-table mdui-typo"> <colgroup><col width="60"><col width=""><col width="80"><col></colgroup>';
			while ($info =$res->fetch_assoc()){
				# code...
				echo "<tr><td>$i</td><td><a href='../content.php?i=".$info['id']."'>".$info['title']."</a></td><td>".dataTo(intval((strtotime("now") - strtotime($info['time']))/86400)).'前'."</td></tr>";
				$i++;
			}
			if(!$i) echo '<tr><td colspan="3">空空如也~~~</td></tr>';
			if($allNum > 1) echo "<tr><td colspan='3'>";
			if ($page != 1) echo '<a href="javascript:;">上一页</a>';
			if ($allNum > 2) {
				for ($i=1;$i<=$allNum;$i++) {
					if($page == $i) {
						echo "<span>".$i."</span>";
						continue;
					}
					echo '<a href="javascript:;">'.$i.'</a>';
				}
			}
			if ($page<$allNum){
				echo '<a href="javascript:;" >下一页</a>';
			}
			if($allNum > 1) echo "</tr></td>";
		    echo '</table>';
			break;
	case 'fav':
			# 用户收藏文章遍历...
		echo '<table class="layui-table mdui-typo"> <colgroup><col width="60"><col width=""></colgroup>';
		$i=0;$fav = explode(',',$user['fav']);
		$limit = ($page-1) * $pageSize;
		while (isset($fav[$i])){
				# code...
			$con = sqlSelect('os','id',$fav[$i]);
			echo "<tr><td>$i</td><td><a href='../content.php?i=".$con['id']."'>".$con['title']."</td></tr>";
			$i++;
		}if(!$i) echo '<tr><td colspan="2">空空如也~~~</td></tr>';
	    echo '</table>';
			break;
	case 'comments':
			# 用户发表评论遍历·...
		echo '<table class="layui-table mdui-typo"> <colgroup><col width="60"><col width=""><col width="95"><col></colgroup>
		     <thead><tr><td>编号</td><td>内容</td><td>发布时间</td></tr></thead>';
		$allNum=ceil(sqlNum('reply','userid',$id) / $pageSize);
		$limit = ($page-1) * $pageSize;
		$sql = "SELECT * FROM  `reply` WHERE `userid` = '$id' LIMIT $limit, $pageSize;";
		$res = $conn->query($sql);
		$i=0;
		while ($info =$res->fetch_assoc()){
				# code...
			echo "<tr><td rowspan='2'>$i</td><td>".$info['con']."</td><td>".dataTo(intval((strtotime("now") - strtotime($info['time']))/86400)).'前'."</td></tr>";
			$con = sqlSelect('os','id',$info['conid']);
			echo "<tr><td colspan='2'><a href='../content.php?i=".$con['id']."'>".$con['title']."</td></tr>";
			$i++;
		}if(!$i) echo '<tr><td colspan="2">空空如也~~~</td></tr>';
			if($allNum > 1) echo "<tr><td colspan='3'>";
			if ($page != 1) echo '<a href="javascript:;">上一页</a>';
			if ($allNum > 2) {
				for ($i=1;$i<=$allNum;$i++) {
					if($page == $i) {
						echo "<span>".$i."</span>";
						continue;
					}
					echo '<a href="javascript:;">'.$i.'</a>';
				}
			}
			if ($page<$allNum){
				echo '<a href="javascript:;" >下一页</a>';
			}
			if($allNum > 1) echo "</tr></td>";
	    echo '</table>';
			break;
		
		default:
			print_r(null);
			break;
	}
}
/*
*登陆功能实现
*需要POST传入 name pw
*成功返回 I`m OK!
*失败返回 各种原因！
*/
if(isset($_POST['Login'])){
	//code..
	$name = $_POST['name'];
	$pw = $_POST['pw'];
	$cookie = isset($_POST['cookie'])?$_POST['cookie']:null;
	if($name==""||$pw=="") die("错误,账号或密码不能为空!");
	$time = date('y-m-d h:i:s',time());
	$sql="SELECT * FROM  `user` WHERE `name` = '$name'";
	$result = $conn -> query($sql);
	$num = $result->num_rows;
	if($num == 0) die('用户名不存在，请先注册！');
	$sql="SELECT * FROM `user` WHERE `name` ='$name' and `pw` = '$pw'";
	$result=$conn->query($sql); 
	$num=$result->num_rows;
	if($num == 0) die('密码不正确，请检查后重试！');
	$info=$result->fetch_assoc();
	SESSION_start();
	$_SESSION['userName']=$info['name'];
	$_SESSION['userId']=$info['id'];
	if($info['vip']==99) $_SESSION['vip']='admin';
	else $_SESSION['vip']=$info['vip'];
	$id = $info['id'];
	if( $cookie == 'is'){
		$_COOKIE['userName'] = $info['name'];
		$_COOKIE['userId'] = $info['id'];
		$_COOKIE['vip'] = '0';
	}
	$time=date("Y-m-d H:i",time());
	$sql="UPDATE `user` SET `login_date`= '$time'  WHERE id=$id";
	if($conn->query($sql)){
		/*$mailtitle = '你的账号'.$name.'登陆提醒--ACG58';
		$mailcontent = '你的账号'.$name.'于'.$time.'成功登陆ACG58社区';
		sendMail($info['email'],$mailtitle,$mailcontent);*/
		die('I`m OK!');
	}
}

/*
*登陆功能实现
*需要POST传入 name pw sex email
*成功返回 I`m OK!
*失败返回 各种原因！
*/
if(isset($_POST['SignUp'])){
	//code..
	$name = $_POST['name'];
	$pw = $_POST['pw'];
	$sex = $_POST['sex'];
	$email = $_POST['email'];
	if($name == ''||$pw == ''|| $sex == ''|| $email == '') die('请先认真填写内容！');
	$sql="SELECT * FROM  `user` WHERE `name` = '$name'";
	$result = $conn -> query($sql);
	$num = $result->num_rows;
	if($num >= 1) die('用户名已存在，请跟换后重试！');
	$time=date("Y-m-d H:i",time());
	$sql = "INSERT INTO `acg`.`user` (`name`, `sex`, `pw`, `email`, `date`) VALUES ('$name', '$sex', '$pw', '$email', '$time');";
	if(!$conn -> query($sql)){
		die("失败，请重试！");
	}else{
		echo "I`m OK!";
		$mailtitle = '欢迎加入ACG58社区';
		$mailcontent = '<h3>ACG58社区欢迎你'.$name.'的加入</h3><p>以下是你的账号信息，请务必牢记</p>';
		sendMail($email,$mailtitle,$mailcontent);
	}
}

/*
*注销功能实现
*需要POST请求 exit
*/
if(isset($_POST['exit'])){
	//code..
	SESSION_start();
	session_destroy();
}


//邮件推送服务
function sendMail($smtpemailto,$mailtitle,$mailcontent){
	//使用方法  
	$post_data = array(  
	  'smtpemailto' => $smtpemailto,  
	  'mailtitle' => $mailtitle,
	  'mailcontent' => $mailcontent
	);  
	send_post('https://qiatia.top/public/PushService/QiaTiaPushMail.php', $post_data);  
  //echo "成功！";
}
?>