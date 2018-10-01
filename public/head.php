<div class="head-banner" style="">
		<div class="boom-banner"></div>
		<nav class="nav-appbar">
			<div class="container">
				<ul class="nav-meun">
					<li><a href="../">首页</a></li>
					<?php
						include_once 'sql.php';
						date_default_timezone_set('PRC');
						$sql = "SELECT * FROM  `class` ORDER BY `id` ASC LIMIT 0,30";
						$result = $conn->query($sql);
						while ($info = $result->fetch_assoc( )) {
					?>
					<li><a mdui-tooltip="{content: '<?php echo $info['cate'];?>'}"  href="../cate.php?cate=<?php echo $info['id']?>"><?php echo $info['info']?></a></li>
					<?php
					}?>
				</ul>
			</div>
		</nav>
</div>