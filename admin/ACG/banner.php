<?php
include_once '../../public/data.php';
if(isset($_GET["del"])){
	if(!sqlDel('banner',$_GET["del"])){
		die("删除失败！");
	}
}
$page = isset($_GET['page'])?$_GET['page']:1;
$pageSize = 24;
$s = isset($_GET['s'])?$_GET['s']:'';
$limit = ($page-1) * $pageSize;
$totalPage = ceil($conn->query("SELECT * FROM  `banner` WHERE `title` like '%$s%'")->num_rows / $pageSize);
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../../public/layui/css/layui.css"  media="all">
	<link rel="stylesheet" type="text/css" href="../../public/css/public.css">
	<link rel="stylesheet" type="text/css" href="./admin.css">
	<style>
		.new{width: 88%; margin: 1rem auto; text-align: right}
		.new>a{margin-left:.5rem}
		.new>a>i{font-size: 1.5rem}
	</style>
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
		<div class="new"><a href="javascript:newBanner();"><i class="layui-icon">&#xe654;</i>添加数据</a></div>
		<table class="layui-table">
			<colgroup><col width="60"><col width=""><col width=""><col width="170"><col width="90"><col></colgroup>
		    <thead><tr><td>编号</td><td>标题</td><td>图片地址</td><td>连接</td><td>操作</td></tr></thead>
		    <tbody>
<?php
$sql = "SELECT * FROM  `banner` WHERE `title` like '%$s%' ORDER BY `id` DESC LIMIT ".$limit." , ".$pageSize;
$result = $conn->query($sql);
while($info = $result->fetch_assoc()){
	//code~~
	echo "<tr><td>{$info['id']}</td><td>{$info['title']}</td><td>{$info['img-src']}</td><td>{$info['href']}</td><td>
	<a href=\"javascript:edit({$info['id']});\"><i class=\"layui-icon\">&#xe642;</i></a>
	<a href=\"javascript:del({$info['id']});\"><i class=\"layui-icon red\">&#xe640;</i></a>
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
			<hr class="layui-bg-blue">
			<h2 style="text-align: center;background-color: #eee;padding: 1rem;border-radius: 5px;color: #ff4081;font-weight: 700">预览区域</h2>
	</div>
<div class="slideshow">
		<button class="slide-btn slide-last" onclick="moveLast()"></button>
		<button class="slide-btn slide-next" onclick="moveNext()"></button>
		<div class="img-banner">
			<?php 
			$res = $conn->query('SELECT *  FROM  `banner` ORDER BY `id` DESC  LIMIT 0 , 10');
			while ($banner = $res->fetch_assoc()) {
			?>
			<a class="banner" href="../../<?php echo $banner['href']?>" target='_blank'>
				<img src="../../<?php echo $banner['img-src']?>" alt="img-banner">
				<div class="title"><?php echo $banner['title']?></div>
				<div class="box-shadow"></div>
			</a>
			<?php } ?>
		</div>
	</div>
<script src="//libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script src="//cdn.90so.net/layui/2.2.6/layui.js " charset="utf-8"></script>
<script src="../../public/js/slideshow.js"></script>
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
			window.location='./banner.php?del='+del;
		});
		return 0;
	}function edit(edit){
		layer.confirm('确认要编辑该条数据？', {icon: 3, title:'来自ACG58的提示'}, function(index){
			layer.close(index);
			layer.open({
			  type: 2,
			  content: './bannerEdit.php?i='+edit,
			  shadeClose:true,
			  resize:false,
			  area: ['450px','295px'],
			  success: function(layero, index){
			    layer.setTop(layero); //重点2
			  }
			});
		});
		return 0;
	}function newBanner(){
		layer.open({
			type: 2,
			content: './bannerNew.php',
			shadeClose:true,
			resize:false,
			area: ['450px','295px'],
			success: function(layero, index){
			  layer.setTop(layero); //重点2
			}
		});
		return 0;
	}
</script>
</body>
</html>