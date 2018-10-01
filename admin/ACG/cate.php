<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="../../public/layui/css/layui.css"  media="all">
	<link rel="stylesheet" type="text/css" href="../../public/css/public.css">
	<link rel="stylesheet" type="text/css" href="./admin.css">
</head>
<body>
<?php
include_once '../../public/data.php';
if(isset($_GET["del"])){
	if(!sqlDel('class',$_GET["del"])) die("删除失败！");
}
?>
<div class="container-fluid">
		<table class="layui-table">
			<colgroup><col width="60"><col width=""><col width=""><col width="75"><col width="35"><col></colgroup>
		    <thead><tr><td>编号</td><td>简称</td><td>具体</td><td>帖子数</td><td><i class="layui-icon red">&#xe640;</i></td></tr></thead>
		    <tbody>
<?php 
$sql = "SELECT * FROM  `class` ORDER BY `id` ASC";
$result = $conn->query($sql);
while($info = $result->fetch_assoc()){
	echo "<tr><td>{$info['id']}</td><td>{$info['info']}</td><td>{$info['cate']}</td><td>".sqlNum('os','cate',$info['cate'])."</td><td>
		<a href=\"javascript:del({$info['id']});\"><i class=\"layui-icon red\">&#xe640;</i></a>
	</td></tr>";
}
?>
		    </tbody>
		</table>
	</div>
<script src="//libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script src="//cdn.90so.net/layui/2.2.6/layui.js " charset="utf-8"></script>
<script type="text/javascript">
	var layer;
	layui.use('layer', function(){layer = layui.layer;});
	$('input[name=cate]').click(function(){
		 document.getElementById('search').submit();
	});
	function del(del,file){
		layer.confirm('确认要删除该条数据？', {icon: 3, title:'来自ACG58的提示'}, function(index){
			layer.msg('正在删除！'+del);
			layer.close(index);
			window.location='./cate.php?del='+del+'&file='+file;
		});
	}
</script>
</body>
</html>