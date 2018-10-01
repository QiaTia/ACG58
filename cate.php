<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<title>ACG58动漫社区</title>
	<link href="https://lib.baomitu.com/mdui/0.4.1/css/mdui.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="./public/css/public.css">
	<style type="text/css">
		select,option{width: 100%;}
	</style>
</head>
<body class="mdui-theme-primary-blue-grey">
	<div class="head-banner">
		<div class="boom-banner"></div>
		<nav class="nav-appbar">
			<div class="container">
				<ul class="nav-meun">
					<li><a href="./">首页</a></li>
					<?php
						include_once 'public/sql.php';
						include_once 'public/data.php';
						date_default_timezone_set('PRC');
						if(isset($_GET['exit'])) {
							session_start();
							session_unset();
							session_destroy();
						}
						$id = isset($_GET['cate'])?$_GET['cate']:1;;
						$page = isset($_GET['page'])?$_GET['page']:1;
						$pageSize = 24;
						$limit = ($page-1) * $pageSize;
						$sql = "SELECT * FROM  `class` ORDER BY `id` ASC ";
						$result = $conn->query($sql);
						while ($info = $result->fetch_assoc()) {
							$class[$info['id']] = $info['cate'];
					?>
					<li <?php if ($id == $info['id']) { $cate = $info['cate']; echo "class='active'"; }?>><a mdui-tooltip="{content: '<?php echo $info['cate'];?>'}"  href="cate.php?cate=<?php echo $info['id']?>"><?php echo $info['info']?></a></li>
					<?php
					}?>
				</ul>
				<div class="nav-right">
					<ul class="nav-meun nav-user nav-meun-right">
						<li><a href="./user/Login.html">登陆</a></li>
					</ul>
				</div>
			</div>
		</nav>
	</div>
	<div class="container" style="margin-top: 10px;">
		<div class="cate-con">
			<div class="cate-head">
				<div class="cate-title"><a href="javascript:;"><?php echo $cate;?></a></div>
			</div>
			<div class="cate-content  mdui-row-sm-4 mdui-row-md-4 mdui-row-lg-6 mdui-row-xs-3">
				<?php
				$sql = "SELECT * FROM  `os` WHERE  `cate` =  '".$class[$id]."' ORDER BY `time` DESC LIMIT ".$limit." , ".$pageSize;
				$result = $conn->query($sql);
				$totalPage = ceil($conn->query("SELECT * FROM  `os` WHERE  `cate` = '".$class[$id]."'")->num_rows / $pageSize);
				while($con = $result->fetch_assoc()){
				?>
				<div class="card mdui-col mdui-hoverable">
					<a href="content.php?i=<?php echo $con['id']?>">
					<div class="card-media">
						<img class="card-img" src="images/avatar/<?php echo $con['coer']?>" alt="card-img">
						<div class="title"><?php echo $con['title']?></div>
					</div></a>
					<div class="card-foot">
						<a href="user/?id=5">
							<img class="foot-avatar" src="images/user/<?php echo sqlSelect('user','id',$con['user_id'])['coer']?>" alt="QiaTia">
							<div class="foot-title"><?php echo $con['user_name']?></div>
						</a>
						<div class="foot-subtitle"><?php echo dataTo(intval((strtotime("now") - strtotime($con['time']))/86400)).'前'?></div>
					</div>
				</div>
				<?php }?>
			</div>
		</div>
		<div class="page mdui-typo">
			<hr>
			<?php 
			if ($page != 1) echo '<a href="cate.php?cate='.$id.'&page='.($page-1).'">上一页</a>';
			if ($totalPage > 2) {
				for ($i=1;$i<=$totalPage;$i++) {
					if($page == $i) {
						echo "<span>".$i."</span>";
						continue;
					}
					echo '<a href="cate.php?cate='.$id.'&page='.$i.'">'.$i.'</a>';
				}
			}
			if ($page<$totalPage){
				echo '<a href="cate.php?cate='.$id.'&page='.($page+1).' " >下一页</a>';
			}
			?>
		</div>
		<?php include_once 'public/foot.php';?>
	</div>
	<script src="//libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
	<script src="https://lib.baomitu.com/mdui/0.4.1/js/mdui.min.js"></script>
	<script src="./public/js/public.js"></script>
	<script type="text/javascript">
		var cate = "<?php echo $cate;?>"; //获取div元素
		document.title=cate+' — ACG58社区';
	</script>
</html>