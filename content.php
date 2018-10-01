<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<title>ACG58动漫社区</title>
	<link href="https://lib.baomitu.com/mdui/0.4.1/css/mdui.min.css" rel="stylesheet">
	<link rel="stylesheet" href="./public/css/shaky.css">
	<link rel="stylesheet" type="text/css" href="./public/css/public.css">
    <link rel="stylesheet" href="//cdn.90so.net/layui/2.2.6/css/layui.css"  media="all">
	<style type="text/css">
		.reply{ position: relative; }
        .reply > .reply_btn{ position: absolute; right: 0rem; bottom: 6px}
        .replyContent{ background-color: #FFF; border-radius: 5px; margin-top:16px}
        .reply_text{border-radius: 10px;background-color:#FFF}
        .color{ color: #FF4180}
        .boomTool>div,.boomTool>a{ float: left; height: 35px; margin-top: 5px; line-height: 35px; margin-right: 15px; display: inline-block}
        .boomTool>div>i{color: #ff4081; margin-right: 2px}
        .boomTool{ margin: 15px auto; display: inline-block}
        .boomTool>.tool{ border-radius: 5px; border: solid 1px skyblue; padding: 0 15px}
        .boomTool>.share{ width: 35px; border-radius: 50%; border: solid 1px skyblue}
        .boomTool>.share:hover,.boomTool>div:hover{ background-color: rgba(255,40,81,.33)}
        .share>img{ height: 24px; width: 24px; vertical-align: middle; margin-left: 5.5px}
        .copyl{position: relative}
        .copyl>a{position: absolute; right: 1rem;top:2rem}
        .mdui-btn-icon .mdui-icon{transform: translate(-18px,-18px);color:#FF4081}
        #copyVal{ display: none}
        @media (min-width:600px){.boomTool{ display: inline-block; width: auto; margin: 15px auto; margin-left: calc(50% - 219px)} }
	</style>
	</head>
<body class="mdui-theme-primary-blue-grey">
	<!-- 加载层动画 -->
  <div class="load">
  	<div class="spinner">
		<div class="bounce1"></div>
		<div class="bounce2"></div>
		<div class="bounce3"></div>
	</div>
  </div>
	<div class="head-banner">
		<div class="boom-banner"></div>
		<nav class="nav-appbar">
			<div class="container">
				<ul class="nav-meun">
					<li><a href="./">首页</a></li>
					<?php 
						include_once 'public/sql.php';
						include_once 'public/data.php';
						session_start();
						if(isset($_GET['exit'])) {
							session_unset();
							session_destroy();
						}
						$id = $_GET['i'];
						$sql="SELECT * FROM os WHERE `id` = '$id'";//查询表
						$result = $conn->query($sql);
						$info = $result->fetch_assoc();
						$cateInfo=$info["cate"];
						$cateThis = $conn->query("SELECT * FROM  `class` WHERE  `cate` =  '$cateInfo'")->fetch_assoc();
						$sql = "SELECT * FROM  `class` ORDER BY `id` ASC ";
						$result = $conn->query($sql);
						while ($cate = $result->fetch_assoc()) {
					?>
					<li <?php if($cateInfo == $cate['cate']) echo "class='active'";?>><a mdui-tooltip="{content: '<?php echo $cate['cate'];?>'}" href="cate.php?cate=<?php echo $cate['id']?>"><?php echo $cate['info']?></a></li>
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
	<div class="container" >
		<?php
			if($info == ''){
				echo "<h2 align='center' style='line-height:255px;'>该文章不存在</h2>";
				include_once 'public/foot.php';
				die('</div>');
			}
		?>
		    <!--内容小标题部分-->
		<div class="mdui-typo-title" style="margin-top: 16px;">
            <a href="cate.php?cate=<?php echo $cateThis['id'];?>"  mdui-tooltip="{content: '<?php echo $info['cate'];?>'}">
                <div class="mdui-chip">
                    <span class="mdui-chip-icon"><?php echo substr($info['cate'],0,1);?></span>
                    <span class="mdui-chip-title"><?php echo $cateThis['info'];?></span>
                </div>
            </a>
            <a href="user/?id=<?php echo $info['user_id']?>" mdui-tooltip="{content: '<?php echo $info['user_name']?>'}">
                <div class="mdui-chip">
                    <img class="mdui-chip-icon" src="images/user/<?php echo sqlSelect('user','id',$info['user_id'])['coer']?>"/>
                    <div class="mdui-chip-title"><?php echo $info['user_name']?></div>
                </div>
            </a>
                <div class="mdui-chip" mdui-tooltip="{content: '<?php echo $info['time']?>'}">
                    <span class="mdui-chip-icon"><i class="mdui-icon material-icons">access_time</i></span>
                    <span class="mdui-chip-title"><?php echo dataTo(intval((strtotime("now") - strtotime($info['time']))/86400)).'前';?></span>
                </div>
            <a href="#reply" mdui-tooltip="{content: '跳转到评论'}">
                <div class="mdui-chip">
                    <span class="mdui-chip-icon"><i class="mdui-icon material-icons">comment</i></span>
                    <span class="mdui-chip-title"> <?php echo $conn->query("SELECT * FROM  `reply` WHERE  `conid` ='$id'")->num_rows; ?> </span>
                </div>
            </a>
            <hr>
        </div>
		<div class="content mdui-typo" style="margin-bottom: 16px; margin-top: 16px;">
			<?php print_r($info['con']);?>
			<hr/>
		</div>
		    <!--功能按钮区域-->
		<div class="mdui-row-xs-<?php echo ($info['link']== '')?'2':'3'?>">
            <div class="mdui-col">
                <button class="mdui-btn mdui-btn-block mdui-color-theme" onclick="like()"><span class='like <?php 
                $likearray = explode(',',$info['cool']);
                if(in_array($_SESSION['userId'],$likearray)) echo 'color';
                ?>'><i class="mdui-icon material-icons">&#xe8dc;</i></span> 赞一个</button>
            </div>
            	<?php if ($info['link'] != ''){?>
            <div class="mdui-col">
                <button class="mdui-btn mdui-btn-block mdui-color-theme" mdui-dialog="{target: '#downDialog'}"><i class="mdui-icon material-icons">&#xe2c4;</i> 下载</button>
            </div>
           		<?php }?>
            <div class="mdui-col">
                <button class="mdui-btn mdui-btn-block mdui-color-theme" onclick="fav()"><span class="fav <?php echo in_array($_SESSION['userId'],explode(',',$info['fav']))?'color':''; ?>"><i class="mdui-icon material-icons">&#xe87d;</i></span> 收藏</button>
            </div>
        </div>
        <div class="boomTool">
            	<div class="tool" mdui-tooltip="{content: '获赞数'}">
            		<i class="mdui-icon material-icons">&#xe8dc;</i><span class='likeNum'><?php echo count($likearray);?></span>
            	</div>
            	<div class="tool" mdui-tooltip="{content: '发布日期'}"><i class="mdui-icon material-icons">&#xe192;</i><?php echo $info['time'];?></div>
            	<div class="tool" mdui-tooltip="{content: '收藏数'}"><i class="mdui-icon material-icons">&#xe87d;</i><span class="favNum"><?php echo count(explode(',',$info['fav']));?></span></div>
            	<div class="tool" mdui-tooltip="{content: '浏览数'}"><i class="mdui-icon material-icons">&#xe038;</i><?php $flow = $info['flow']+1; 
	            		$sql="UPDATE `os` SET `flow` = '$flow' WHERE `id` = '$id';"; 
	            		$conn->query($sql);
	            		echo $flow?>
            	</div>
            	<a href="javascript:share(0,'<?php echo $info['user_name']?>','images/avatar/<?php echo $info['coer']?>');" mdui-tooltip="{content: '分享到QQ'}" class="share"> <img src="./images/icon/qq.png" alt="shareToQQ"></a>
            	<a href="javascript:share(1,'<?php echo $info['user_name']?>','images/avatar/<?php echo $info['coer']?>');" mdui-tooltip="{content: '分享到微博'}" class="share"><img src="./images/icon/weibo.png" alt="shareToWeibo"></a>
            </div>
            <!--回复输入区域-->
        <div class="reply" id="reply">
			<div class="mdui-typo-headline-opacity shaky">你想说什么?</div>
            <div class="reply_text" style="width: 100%;">
                <textarea class="layui-textarea replyText"  id="edit" name="replycon" rows="5" style="width: 100%; resize:none"></textarea>
            </div>
            <div class="reply_btn">
                <button class="mdui-btn mdui-color-theme" onclick="reply()">回复 <i class="mdui-icon material-icons">send</i> </button>
            </div>
        </div>
            <!--回复内容区域-->
        <div class="replyContent">
            <ul class="mdui-list reply-Content-ul"> </ul>
        </div>
		<?php include_once 'public/foot.php';?>
	</div>
<?php if ($info['link'] != ''){?>
	<!--下载Dialog-->
    <div class="mdui-dialog" id="downDialog">
        <div class="mdui-dialog-title mdui-shadow-1">确认下载 <?php echo $info['title'];?>?</div>
        <div class="mdui-dialog-content">
            <?php if ($info['link_code'] != ''){?>
                <div class="mdui-textfield copyl">
					<label class="mdui-textfield-label">提取码：</label>
					<input class="mdui-textfield-input" type="text" value="<?php echo $info['link_code']?>" />
                    <a onClick="copy('<?php echo $info['link_code']?>')" id="copy" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">&#xe14d;</i></a>
                </div>
            <?php }?>
            <?php if ($info['link_code2'] != ''){?>
                 <div class="mdui-textfield copyl">
					<label class="mdui-textfield-label">解压密码：</label>
					<input class="mdui-textfield-input" type="text" value="<?php echo $info['link_code2']?>" />
                    <a onClick="copy('<?php echo $info['link_code2']?>')" id="copy" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">&#xe14d;</i></a>
                </div>
            <?php }?>
        </div>
        <div class="mdui-dialog-actions">
            <a href="<?php echo $info['link']?>"  target="_blank" class="mdui-btn mdui-btn-block mdui-color-theme mdui-ripple" mdui-dialog-confirm>去下载</a>
        </div>
    </div>
    <?php }?>
	<script src="//libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
	<script src="https://lib.baomitu.com/mdui/0.4.1/js/mdui.min.js"></script>
    <script src="//cdn.90so.net/layui/2.2.6/layui.js " charset="utf-8"></script>
	<script src="./public/js/public.js"></script>
    <script type="text/javascript">
        var conid = getQueryString('i'),
            title = "<?php echo $info['title'];?>"+' — ACG58社区',
            page = 0; //获取div元素
        document.title=title;
            $(document).ready(function(){
                stopLoading();
        });
    </script>
	<script src="./public/js/reply.js"></script>
</html>