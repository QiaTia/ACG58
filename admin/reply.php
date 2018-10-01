<?php
include_once '../public/data.php';
if(isset($_GET["del"])){
	if(!sqlDel('reply',$_GET["del"])){
		die("删除失败！");
	}
}
$page = isset($_GET['page'])?$_GET['page']:1;
$pageSize = 24;
$s = isset($_GET['s'])?$_GET['s']:'';
SESSION_start();
$user = $_SESSION['userId'];
$limit = ($page-1) * $pageSize;
$totalPage = ceil($conn->query("SELECT * FROM  `reply` WHERE `con` like '%$s%' AND `userid` = '$user'")->num_rows / $pageSize);
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
			<h4>&nbsp;</h4>
		</div>
		<table class="layui-table">
			<colgroup><col width="60"><col width=""><col width="350"><col width="75"><col width="35"><col></colgroup>
		    <thead><tr><td>编号</td><td>回复内容</td><td>回复帖子</td><td>时间</td><td><i class="layui-icon red">&#xe640;</i></td></tr></thead>
		    <tbody>
<?php
$sql = "SELECT * FROM  `reply` WHERE `con` like '%$s%' AND `userid` = '$user' ORDER BY `time` DESC LIMIT ".$limit." , ".$pageSize;
$result = $conn->query($sql);
while($info = $result->fetch_assoc()){
	//code~~
	echo "<tr><td>{$info['id']}</td><td>{$info['con']}</td>
		<td><a href='../content.php?i={$info['conid']}' target='_blank'>".sqlSelect('os','id',$info['conid'])['title']."</a></td>
		<td>".dataTo(intval((strtotime("now") - strtotime($info['time']))/86400))."前</td><td>
	<a href=\"javascript:del({$info['id']});\"><i class=\"layui-icon red\">&#xe640;</i> </a>
	</td></tr>";
}
?></tbody>
	</table>
</div>
<div class="typo">
		<?php
			if ($page != 1) echo '<a href="reply.php?s='.$s.'&page='.($page-1).'">上一页</a>';
			if ($totalPage > 2) {
				for ($i=1;$i<=$totalPage;$i++) {
					if($page == $i) {
						echo "<span>".$i."</span>";
						continue;
					}
					echo '<a href="reply.php?s='.$s.'&page='.$i.'">'.$i.'</a>';
				}
			}
			if ($page<$totalPage){
				echo '<a href="reply.php?s='.$s.'&page='.($page+1).' " >下一页</a>';
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
		layer.confirm('确认要删除该条数据？', {icon: 3, title:'来自ACG58的提示'}, function(index){
			layer.msg('正在删除！'+del);
			layer.close(index);
			window.location='./content.php?del='+del;
		});
	}
</script>
</body>
</html>