<?php
include_once '../public/data.php';
session_start();
if(isset($_GET["del"])){
	$conId = $_GET["del"];
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
}
$page = isset($_GET['page'])?$_GET['page']:1;
$pageSize = 24;
$cate = isset($_GET['cate'])?$_GET['cate']:'';
$s = isset($_GET['s'])?$_GET['s']:'';
$id = $_SESSION['userId'];
$limit = ($page-1) * $pageSize;
$user = sqlSelect('user','id',$id);
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../public/layui/css/layui.css"  media="all">
	<link rel="stylesheet" type="text/css" href="../public/css/public.css">
	<link rel="stylesheet" type="text/css" href="./ACG/admin.css">
</head>
<body>
	<div class="container-fluid">
		<div class="search">
			<form action="" id='search'>
				<div class="search-input">
					<label for="s"><i class="layui-icon">&#xe615;</i></label>
					<input type="text" name="s" id="s" placeholder="您想搜索什么？" value="<?php echo $s?>" disableautocomplete>
					<ul id="list"></ul>
				</div>
			</form>
		</div>
<table class="layui-table">
	<colgroup><col width="60"><col width=""><col width="95"><col></colgroup>
	<thead><tr><td>编号</td><td>标题</td><td>操作</td></tr></thead>
	<?php 
		$i=0;$fav = explode(',',$user['fav']);
		$limit = ($page-1) * $pageSize;
		$totalPage = ceil(count($fav)/$pageSize);
		while (isset($fav[$i])){
				# code...
			$con = sqlSelect('os','id',$fav[$i]);
			echo "<tr><td>{$i}</td><td>".$con['title']."</td>
				<td><a href='../content.php?i=".$con['id']."' target='_blank'><i class=\"layui-icon\">&#xe64e;</i></a>
				<a href=\"javascript:del({$fav[$i]});\"><i class=\"layui-icon red\">&#xe640;</i></a></td>
			</tr>";
			$i++;
		}if(!$i) echo '<tr><td colspan="3">空空如也~~~</td></tr>';
	    echo '</table>';?>
</div>
<div class="typo">
		<?php
			if ($page != 1) echo '<a href="fav.php?s='.$s.'&page='.($page-1).'">上一页</a>';
			if ($totalPage > 2) {
				for ($i=1;$i<=$totalPage;$i++) {
					if($page == $i) {
						echo "<span>".$i."</span>";
						continue;
					}
					echo '<a href="fav.php?s='.$s.'&page='.$i.'">'.$i.'</a>';
				}
			}
			if ($page<$totalPage){
				echo '<a href="fav.php?s='.$s.'&page='.($page+1).' " >下一页</a>';
			}
			?>
</div>
<script src="//libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script src="../public/layui/layui.js " charset="utf-8"></script>
<script type="text/javascript">
	var layer;
	layui.use('layer', function(){layer = layui.layer;});
	$('input[name=cate]').click(function(){
		 document.getElementById('search').submit();
	});
	function del(del){
		layer.confirm('确认要取消收藏该文章？', {icon: 3, title:'来自ACG58的提示'}, function(index){
			layer.msg('正在删除！'+del);
			layer.close(index);
			window.location='./fav.php?del='+del;
		});
	}
</script>
</body>
</html>