<?php
include_once '../../public/data.php';
if(isset($_GET["del"])){
	$flie = '../../images/avatar/'.$_GET["file"];
	if(!unlink(iconv('gb2312','utf-8','$file')))
		echo "Erro! ".$flie." ";
	if(!sqlDel('os',$_GET["del"])){
		die("删除失败！");
	}
}
$page = isset($_GET['page'])?$_GET['page']:1;
$pageSize = 24;
$cate = isset($_GET['cate'])?$_GET['cate']:'';
$s = isset($_GET['s'])?$_GET['s']:'';
$limit = ($page-1) * $pageSize;
$totalPage = ceil($conn->query("SELECT * FROM  `os` WHERE `cate` like '%$cate%' AND `title` like '%$s%'")->num_rows / $pageSize);
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../../public/layui/css/layui.css"  media="all">
	<link rel="stylesheet" type="text/css" href="../../public/css/public.css">
	<link rel="stylesheet" type="text/css" href="./admin.css">
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
			<div class="search-cate" style="width: 100%">
				<span class="search-cate-title" style="width: 3rem">分类:</span>
				<div class="seach-cate-se">
					<label class="search-cate-option <?php echo ($cate=='')?'checked':null;?>">
						<input type="radio" name="cate" hidden="" value="">
						<span class="search-cate-option-title">全部</span>
					</label>
					<?php
						$sql = "SELECT * FROM  `class` ORDER BY `id` ASC";
						$result = $conn->query($sql);
						$cateText = '';
						while ($info = $result->fetch_assoc()) {
					?>
					<label class="search-cate-option <?php if($cate == $info['cate']) echo 'checked'?>">
						<input type="radio" name="cate" hidden="" value="<?php echo $info['cate'];?>">
						<span class="search-cate-option-title"><?php echo $info['cate'];?></span>
					</label>
					<?php }?>
				</div>
			</div></form>
		</div>
		<table class="layui-table">
			<colgroup><col width="60"><col width=""><col width="135"><col></colgroup>
		    <thead><tr><td>编号</td><td>标题</td><td>操作</td></tr></thead>
		    <tbody>
<?php
$sql = "SELECT * FROM  `os` WHERE `cate` like '%$cate%' AND `title` like '%$s%' ORDER BY `time` DESC LIMIT ".$limit." , ".$pageSize;
$result = $conn->query($sql);
while($info = $result->fetch_assoc()){
	//code~~
	echo "<tr><td>{$info['id']}</td><td>{$info['title']}</td><td>
	<a href=\"javascript:read({$info['id']});\"><i class=\"layui-icon\">&#xe64e;</i> </a>
	<a href=\"javascript:edit({$info['id']});\"><i class=\"layui-icon\">&#xe642;</i> </a>
	<a href=\"javascript:del({$info['id']},'{$info['coer']}');\"><i class=\"layui-icon red\">&#xe640;</i> </a>
	</td></tr>";
}
?></tbody>
	</table>
</div>
<div class="typo">
		<?php
			if ($page != 1) echo '<a href="content.php?s='.$s.'&cate='.$cate.'&page='.($page-1).'">上一页</a>';
			if ($totalPage > 2) {
				for ($i=1;$i<=$totalPage;$i++) {
					if($page == $i) {
						echo "<span>".$i."</span>";
						continue;
					}
					echo '<a href="content.php?s='.$s.'&cate='.$cate.'&page='.$i.'">'.$i.'</a>';
				}
			}
			if ($page<$totalPage){
				echo '<a href="content.php?s='.$s.'&cate='.$cate.'&page='.($page+1).' " >下一页</a>';
			}
			?>
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
			window.location='./content.php?del='+del+'&file='+file;
		});
	}function edit(edit){
		layer.confirm('确认要编辑该条数据？', {icon: 3, title:'来自ACG58的提示'}, function(index){
			layer.close(index);
			window.location='../edit.php?id='+edit;
		});
	}function read(id){
		window.open('../../content.php?i='+id);
	}
</script>
</body>
</html>