<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<title>ACG58动漫社区</title>
	<link href="//lib.baomitu.com/mdui/0.4.1/css/mdui.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="./public/css/public.css">
	<style type="text/css">
		.cate-content{ max-height: 960px;overflow-y:auto;padding-bottom:1.3rem }
	</style>
</head>
<body class="mdui-theme-primary-blue-grey">
	
	<div class="head-banner" style="">
		<div class="boom-banner"></div>
		<nav class="nav-appbar">
			<div class="container">
				<ul class="nav-meun">
					<li class="active"><a href="javascript:;">首页</a></li>
					<?php
						include_once 'public/sql.php';
						include_once 'public/data.php';
						date_default_timezone_set('PRC');
						if(isset($_GET['exit'])) {
							session_start();
							session_unset();
							session_destroy();
						}
						$sql = "SELECT * FROM  `class` ORDER BY `id` ASC LIMIT 0,30";
						$result = $conn->query($sql);
						while ($info = $result->fetch_assoc()) {
					?>
					<li><a mdui-tooltip="{content: '<?php echo $info['cate'];?>'}"  href="cate.php?cate=<?php echo $info['id']?>"><?php echo $info['info']?></a></li>
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
	<div class="slideshow">
		<button class="slide-btn slide-last" onclick="moveLast()"></button>
		<button class="slide-btn slide-next" onclick="moveNext()"></button>
		<div class="img-banner">
			<?php 
			$res = $conn->query('SELECT *  FROM  `banner` ORDER BY `id` DESC  LIMIT 0 , 10');
			while ($banner = $res->fetch_assoc()) {
			?>
			<a class="banner" href="<?php echo $banner['href']?>">
				<img src="<?php echo $banner['img-src']?>" alt="img-banner">
				<div class="title"><?php echo $banner['title']?></div>
				<div class="box-shadow"></div>
			</a>
			<?php } ?>
		</div>
	</div>
	<div class="container" >
		<?php $result = $conn->query("SELECT * FROM  `class` ORDER BY `id` ASC LIMIT 0,30");
		while ($cate = $result->fetch_assoc()) {
		?>
		<div class="cate-con">
			<div class="cate-head">
				<div class="cate-title"><a href="cate.php?cate=<?php echo $cate['id']?>"><?php echo $cate['cate'];?></a></div>
				<a href="javascript:;">请期待</a><a href="javascript:;">请期待</a>
			</div>
			<div class="cate-content  mdui-row-sm-4 mdui-row-md-4 mdui-row-lg-6 mdui-row-xs-3">
				<?php
				$sql = "SELECT * FROM  `os` WHERE  `cate` =  '".$cate['cate']."' ORDER BY `time` DESC LIMIT 0 , 12";
				$res = $conn->query($sql);
				while($con = $res->fetch_assoc()){
				?>
				<div class="card mdui-col mdui-hoverable">
					<a href="content.php?i=<?php echo $con['id']?>">
					<div class="card-media">
						<img class="card-img" src="images/avatar/<?php echo $con['coer']?>" alt="card-img">
						<div class="title"><?php echo $con['title']?></div>
					</div></a>
					<div class="card-foot">
						<a href="user/?id=<?php echo $con['user_id']?>">
							<img class="foot-avatar" src="images/user/<?php echo sqlSelect('user','id',$con['user_id'])['coer']?>" alt="QiaTia">
							<div class="foot-title"><?php echo $con['user_name']?></div>
						</a>
						<div class="foot-subtitle"><?php echo dataTo(intval((strtotime("now") - strtotime($con['time']))/86400)).'前'?></div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
		<?php }
		include_once 'public/foot.php';?>
	</div>
	<script src="//libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
	<script src="//cdn.bootcss.com/mdui/0.4.0/js/mdui.min.js"></script>
	<script src="./public/js/public.js"></script>
	<script src="./public/js/slideshow.js"></script>
	<script type="text/javascript">
        	/*var curId = "";
	        var  items = $('.cate-con');  
	        items.each(function(i,e){  
	            var m = $(this);  
	            var itemsTop = m.offset().top;  
	            if(t>itemsTop-250){  
	                 curId = "#" + m.attr("id");  
	            }else{  
	                return false;  
	            }
	        });*/
	</script>
</body>
</html>