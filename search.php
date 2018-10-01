<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<?php 
		include_once 'public/sql.php';
		include_once 'public/data.php';
		date_default_timezone_set('PRC');
		$s = isset($_GET['s'])?$_GET['s']:'';
		$cate = isset($_GET['cate'])?$_GET['cate']:'';
		if(isset($_GET['exit'])) { session_start(); session_unset(); session_destroy(); }
		$page = isset($_GET['page'])?$_GET['page']:1;
		$pageSize = 24;
		$limit = ($page-1) * $pageSize;
	?>
	<link href="https://lib.baomitu.com/mdui/0.4.1/css/mdui.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="./public/css/public.css">
	<title><?php echo $s?>`搜索结果--ACG58动漫社区</title>
	<style>
		.checked{background-color: rgba(255,40,81,.7);}
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
	<div class="container">
		<div class="search">
			<form action="./search.php" id='search'>
			<div class="search-input">
				<label for="s"><i class="mdui-icon material-icons">&#xe8b6;</i></label>
				<input type="text" name="s" id="s" placeholder="您想搜索什么？" value="<?php echo $s?>" autocomplete="off" disableautocomplete>
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
					<label class="search-cate-option <?php if($cate == $info['id']) {$cateText = $info['cate']; echo 'checked';}?>">
						<input type="radio" name="cate" hidden="" value="<?php echo $info['id'];?>">
						<span class="search-cate-option-title"><?php echo $info['cate'];?></span>
					</label>
					<?php }?>
				</div>
			</div></form>
		</div>
		<div class="cate-con" style="margin-top: 10px">
			<div class="cate-head">
				<div class="cate-title"><a href="javascript:;"><i class="mdui-icon material-icons">&#xe8b6;</i><?php echo $cate;?></a></div>
				<a href="javascript:;"><?php echo $s;?>`搜索结果</a>
			</div>
			<div class="cate-content  mdui-row-sm-4 mdui-row-md-4 mdui-row-lg-6 mdui-row-xs-3">
				<?php
				$sql = "SELECT * FROM  `os` WHERE `cate` like '%$cateText%' AND `title` like '%$s%' ORDER BY `time` DESC LIMIT ".$limit." , ".$pageSize;
				$result = $conn->query($sql);
				$totalPage = ceil($conn->query("SELECT * FROM  `os` WHERE `cate` like '%$cateText%' AND `title` like '%$s%'")->num_rows / $pageSize);
				$i = 0;
				while($con = $result->fetch_assoc()){
				?>
				<article class="card mdui-col mdui-hoverable" style="display:inline-block">
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
				</article>
				<?php 
					$i++; }
					if(!$i) echo "<h1 align='center'>啥也没搜到，换一个词试试？</h1>";
				?>
			</div>
		</div>
		<div class="page mdui-typo">
			<hr>
			<?php
			if ($page != 1) echo '<a href="search.php?s='.$s.'&cate='.$cate.'&page='.($page-1).'">上一页</a>';
			if ($totalPage > 2) {
				for ($i=1;$i<=$totalPage;$i++) {
					if($page == $i) {
						echo "<span>".$i."</span>";
						continue;
					}
					echo '<a href="search.php?s='.$s.'&cate='.$cate.'&page='.$i.'">'.$i.'</a>';
				}
			}
			if ($page<$totalPage){
				echo '<a href="search.php?s='.$s.'&cate='.$cate.'&page='.($page+1).' " >下一页</a>';
			}
			?>
		</div>
		<?php include_once 'public/foot.php';?>
	</div>

	<script src="//libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
	<script src="https://lib.baomitu.com/mdui/0.4.1/js/mdui.min.js"></script>
	<script src="./public/js/public.js"></script>
	<script type="text/javascript">
		$('input[name=cate]').click(function(){
			 document.getElementById('search').submit();
		});
		var oTxt = document.getElementById("s"),
			oUl = document.getElementById("list");
　　　　oTxt.onkeyup = function(){
	　　　　var val = oTxt.value;
	　　　　var oScript = document.createElement('script');
	　　　　oScript.src = "//suggestion.baidu.com/su?wd="+val+"&cb=Text";
	　　　　document.body.appendChild(oScript);
	　　　　document.body.removeChild(oScript);
	　　};　
	　　function Text(data){
	　　　　var str = '';
	　　　　for(var i = 0;i<data.s.length;i++){
	　　　　　　str += '<li><a href="./search.php?s='+data.s[i]+'&cate=<?php echo $cate?>">'+data.s[i]+'</a></li>';
	　　　　}
	　　　　oUl.innerHTML = str;
	　　　　oUl.style.display = 'block';
	　　}
		/*$('#s').on('input',function(){
			$.get('//sp0.baidu.com/5a1Fazu8AA54nxGko9WTAnF6hhy/su?wd='+$(this).val()+'&json=1',function(sug){
				console.log(sug);
			});
			$.ajax({
			 	type:"get",
			 	url:'//suggestion.baidu.com/su?wd='+$(this).val()+'&json=1&p=3&cb=resultcallback',
			 	dataType:"jsonp",
			 	function(sug){
					console.log(sug);
				}
			});
        })*/
	</script>
</body>
</html>