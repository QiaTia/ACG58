<?php 
SESSION_start();
if(!isset($_SESSION['userId'])) die('<h1 style="text-align:center">ERRO! 404 Page</h1>');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<title>后台管理--ACG58动漫社区</title>
	<link rel="stylesheet" href="../public/layui/css/layui.css"  media="all">
	<style type="text/css">
		*{padding: 0;margin: 0}
		body{position:relative;}
		.nav-side{position: absolute; top:0;left:0;min-width:60px;width:220px;height:100vh;background-color: #20222A;overflow: hidden}
		.admin{position: absolute;top:0;left:220px;height:100vh;width: calc(100vw - 220px);position:relative; display: block}
		.nav-side,.admin{transition:All .3s ease-in-out}
		.nav-appbar{position:absolute;top:0;height: 50px;width: 100%;background-color: #393D49;line-height: 50px}
		.admin-body{position:absolute;top:50px;width: 100%;background-color:#eee;height: calc(100vh - 50px)}
		.iframe{width:calc(100% - 1rem);height:calc(100% - 1.2rem); border-width:0px;padding: .5rem}
		.layui-icon,a{color:#DDD}.layui-icon{font-size:1.5rem}
		a:hover>.layui-icon{color: #FF4081}
		.meun-toggle{margin-left:1rem}
		.nav-side>li,.nav-side>li>a{height: 50px;line-height: 50px}
		.nav-side>li{font-size: 1rem;overflow:hidden;white-space:nowrap;transition:All .3s ease}
		.side-title{display:block;text-align: center;overflow:hidden;white-space:nowrap;height: 50px;line-height: 50px}
		.nav-side>li>a{padding-left:1rem}
		.nav-side>li>a>i{margin-right:1rem}
		.nav-side>li:hover{border-right:solid #FF4081 5px;background-color:#181C2A}
		.nav-right{float:right;line-height:50px;height:50px;margin-right:1.5rem}
		.nav-right>li{float:left;list-style:none;padding:0 .7rem}
		.nav-right>li:hover{border-top:solid #FF4081 3px;background-color:#2B3249}
		::selection{ background: rgba(255,40,81,.5); color: #fff}
		#note>textarea{font-size: 1.1rem;color: #333}
	</style>
</head>
<body>
	<!-- 侧边栏 -->
	<ul class="nav-side">
		<a href="javascript:;" class="side-title"><h3>ACG58后台管理</h3></a>
		<li><a href="javascript:iframe('console');"><i class="layui-icon">&#xe68e;</i><span>主页</span></a></li>
		<hr class="layui-bg-green">
		<li><a href="javascript:iframe('fav');"><i class="layui-icon">&#xe600;</i><span>我的收藏</span></a></li>
		<li><a href="javascript:iframe('content');"><i class="layui-icon">&#xe653;</i><span>我的帖子</span></a></li>
		<li><a href="javascript:iframe('followers');"><i class="layui-icon">&#xe770;</i><span>我的订阅</span></a></li>
		<li><a href="javascript:iframe('reply');"><i class="layui-icon">&#xe63a;</i><span>我的吐槽</span></a></li>
		<hr class="layui-bg-green">
		<li><a href="javascript:iframe('setting');"><i class="layui-icon">&#xe614;</i><span>个人资料</span></a></li>
		<li><a href="javascript:iframe('about');"><i class="layui-icon">&#xe702;</i><span>关于</span></a></li>
	</ul>
	<!-- 右边内容栏目 -->
	<div class="admin">
		<!-- 顶部导航栏 -->
		<div class="nav-appbar">
			<a href="javascript:meunToggle();" class="meun-toggle"><i class="layui-icon">&#xe668;</i></a>
			<ul class="nav-right">
				<li><a href="javascript:note();"><i class="layui-icon">&#xe66e;</i></a></li>
				<li><a href="javascript:Fullscreen();"><i class="layui-icon">&#xe638;</i></a></li>
				<li><a href="javascript:closeTag();"><i class="layui-icon">&#x1006;</i></a></li>
			</ul>
			<div class="nav-right">
				<div id="tp-weather-widget"></div>
               	<script>(function(T,h,i,n,k,P,a,g,e){g=function(){P=h.createElement(i); a=h.getElementsByTagName(i)[0];P.src=k;P.charset="utf-8";P.async=1;a.parentNode.insertBefore(P,a)};T["ThinkPageWeatherWidgetObject"]=n;T[n]||(T[n]=function(){(T[n].q=T[n].q||[]).push(arguments)});T[n].l=+new Date();if(T.attachEvent){T.attachEvent("onload",g)}else{T.addEventListener("load",g,false)}}(window,document,"script","tpwidget","//widget.seniverse.com/widget/chameleon.js"));tpwidget("init", {"flavor": "slim","location": "WX4FBXXFKE4F","geolocation": "enabled","language": "zh-chs","unit": "c","theme": "chameleon","container": "tp-weather-widget","bubble": "disabled","alarmType": "badge","color": "#FFFFFF","uid": "U9EC08A15F","hash": "039da28f5581f4bcb5c799fb4cdfb673"});tpwidget("show");</script>
           </div>
		</div>
		<!-- 内容布局 -->
		<div class="admin-body">
			<iframe src="./console.php" name="adminBody" class="iframe"></iframe>
		</div>
	</div>
	<div id="note" style="display: none">
		<textarea style="min-width: 350px;min-height: 150px;border:none;">在这里输入你需要处理的内容，下次打开内容还会存在哟~</textarea>
	</div>
	<script src="//libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
	<script src="../public/layui/layui.js " charset="utf-8"></script>
	<script type="text/javascript">
		var meun = 0
			,rame = getQueryString('rame')
			,fullscreenEnabled = 1
			,layer;
		layui.use('layer', function(){
  			layer = layui.layer;
  			layer.msg('hello!欢迎来到acg58社区个人中心！');
  		});
  		if(rame!=null) iframe(rame);
		function meunToggle() {
			if(!meun){
				$('.nav-side').width(60);
				$('.admin').css({'left':'60px','width':'calc(100vw - 60px)'});
				$('.meun-toggle > i').html('&#xe66b;');
				$('.nav-side>li>a>span').hide();
				meun = 1;
			}else{
				$('.nav-side').width(220);
				$('.admin').css({'left':'220px','width':'calc(100vw - 220px)'});
				$('.meun-toggle > i').html('&#xe668;');
				$('.nav-side>li>a>span').show();
				meun = 0;
			}
			return 0;
		}
		function iframe(msg) {
			window.frames["adminBody"].location.href=msg+'.php';
			meun = 1;
			meunToggle();
			return 0;
		}
		function launchFullscreen(element) {
			if(element.requestFullscreen) {
				element.requestFullscreen();
			} else if(element.mozRequestFullScreen) {
				element.mozRequestFullScreen();
			} else if(element.webkitRequestFullscreen) {
			 	element.webkitRequestFullscreen();
			} else if(element.msRequestFullscreen) {
				element.msRequestFullscreen();
			}
			return 1;
		}
		function exitFullscreen() {
			if(document.exitFullscreen) {
		  		document.exitFullscreen();
		 	} else if(document.mozCancelFullScreen) {
		 		 document.mozCancelFullScreen();
		 	} else if(document.webkitExitFullscreen) {
		  		document.webkitExitFullscreen();
		 	}
		 	return 0;
		}
		function Fullscreen() {
			if(fullscreenEnabled){
				launchFullscreen(document.documentElement);
				fullscreenEnabled = 0;
			} else{
		 		exitFullscreen();
		 		fullscreenEnabled = 1;
			}
		}
		function closeTag() {
			window.history.back(-1);
			window.location.href='../';
		}
		function getQueryString(name) { 
			var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i"); 
			var r = window.location.search.substr(1).match(reg); 
			if (r != null) return unescape(r[2]); return null; 
		}
		function note() {
			layer.open({
			  type: 1,
			  title:'便戈',
			  shadeClose:true,
			  resize:false,
			  content: $('#note') //这里content是一个DOM，注意：最好该元素要存放在body最外层，否则可能被其它的相对元素所影响
			});
		}
		$(document).ready(function(){
			var msg=localStorage.note;
			if(msg!='') $('#note>textarea').val(msg);
			$('#note>textarea').blur(function(){
				localStorage.note = $('#note>textarea').val();
			})
		});
	</script>
</body>
</html>