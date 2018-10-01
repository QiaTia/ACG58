<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../../public/layui/css/layui.css"  media="all">
	<link rel="stylesheet" type="text/css" href="../../public/css/public.css">
	<link rel="stylesheet" type="text/css" href="./admin.css">
</head>
<body>
<?php
include_once '../../public/data.php';
if(isset($_GET["del"])){
	if(!sqlDel('user',$_GET["del"])) die("删除失败！");
}if(isset($_GET["edit"])){
	$edit = $_GET["edit"];
	if(!$conn->query("UPDATE `user` SET `pw` = 'e10adc3949ba59abbe56e057f20f883e' WHERE  `id` =$edit")) die('重置失败!');
}
$page = isset($_GET['page'])?$_GET['page']:1;
$pageSize = 24;
$s = isset($_GET['s'])?$_GET['s']:'';
$limit = ($page-1) * $pageSize;
$totalPage = ceil($conn->query("SELECT * FROM  `user` WHERE `name` like '%$s%'")->num_rows / $pageSize);
?>
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
			<colgroup><col width="60"><col width=""><col width=""><col width="120"><col width="60"><col width="135"><col></colgroup>
		    <thead><tr><td>编号</td><td>用户名</td><td>邮箱地址</td><td>最近上线</td><td>性别</td><td>操作</td></tr></thead>
		    <tbody>
<?php 
$sql = "SELECT * FROM  `user` WHERE `name` like '%$s%' ORDER BY `id` ASC LIMIT ".$limit." , ".$pageSize;
$result = $conn->query($sql);
while($info = $result->fetch_assoc()){
	echo "<tr><td>{$info['id']}</td><td>{$info['name']}</td><td>{$info['email']}</td><td>".dataTo(intval((strtotime("now") - strtotime($info['login_date']))/86400))."前</td><td>".($info['sex']?'女':'男')."</td><td>
	<a href=\"javascript:read({$info['id']});\"><i class=\"layui-icon\">&#xe64e;</i> </a>
	<a href=\"javascript:edit({$info['id']});\"><i class=\"layui-icon\">&#xe666;</i> </a>
	<a href=\"javascript:del({$info['id']});\"><i class=\"layui-icon red\">&#xe640;</i> </a>
	</td></tr>";
}
?>
		    </tbody>
		</table>
		<div class="typo">
		<?php
			if ($page != 1) echo '<a href="content.php?s='.$s.'&page='.($page-1).'">上一页</a>';
			if ($totalPage > 2) {
				for ($i=1;$i<=$totalPage;$i++) {
					if($page == $i) {
						echo "<span>".$i."</span>";
						continue;
					}
					echo '<a href="content.php?s='.$s.'&page='.$i.'">'.$i.'</a>';
				}
			}
			if ($page<$totalPage){
				echo '<a href="content.php?s='.$s.'&page='.($page+1).' " >下一页</a>';
			}
			?>
	</div>
	</div>
<script src="//libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script src="//cdn.90so.net/layui/2.2.6/layui.js " charset="utf-8"></script>
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
			window.location='./user.php?del='+del;
		});
	}function edit(edit){
		layer.confirm('确认要重置他的密码？', {icon: 3, title:'来自ACG58的提示'}, function(index){
			window.location='./user.php?edit='+edit;
		});
	}function read(id){
		 window.open('../../user/?id='+id);
	}
</script>
</body>
</html>