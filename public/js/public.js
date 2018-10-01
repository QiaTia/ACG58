/**
 *                  ___====-_  _-====___
 *            _--^^^#####//      \\#####^^^--_
 *         _-^##########// (    ) \\##########^-_
 *        -############//  |\^^/|  \\############-
 *      _/############//   (@::@)   \\############\_
 *     /#############((     \\//     ))#############\
 *    -###############\\    (oo)    //###############-
 *   -#################\\  / VV \  //#################-
 *  -###################\\/      \//###################-
 * _#/|##########/\######(   /\   )######/\##########|\#_
 * |/ |#/\#/\#/\/  \#/\##\  |  |  /##/\#/  \/\#/\#/\#| \|
 * `  |/  V  V  `   V  \#\| |  | |/#/  V   '  V  V  \|  '
 *    `   `  `      `   / | |  | | \   '      '  '   '
 *                     (  | |  | |  )
 *                    __\ | |  | | /__
 *                   (vvv(VVV)(VVV)vvv)                
 *                        神兽保佑
 *                       代码无BUG!
 */
$.post('public/submit.php',{navUser:'null'},function(data){
	$('.nav-user').html(data);
});
$(document).ready(function(){
	$('.search-fot').click(function(){$('.search-fot').fadeOut("slow");});
	$(".search-fot>form").click(function(event){event.stopPropagation();});
});
//滑动屏幕时
window.onscroll = function() {
	var t = document.documentElement.scrollTop || document.body.scrollTop, //获取距离页面顶部的距离
		i = t / (document.body.offsetHeight - window.innerHeight);
	if (t >= 120) {
		$('.nav-appbar').addClass('navbar-fixed-top top-bg');
	} else if (t < 120) {
		$('.nav-appbar').removeClass('navbar-fixed-top top-bg');
	}
	if (t >= 300) { //当距离顶部超过300px时
		uptop.style.bottom = 15 + 'px'; //使div距离底部30px，也就是向上出现
	} else { //如果距离顶部小于300px
		uptop.style.bottom = -70 + 'px'; //使div向下隐藏
	}
	i = Math.round(i * 100);
	if (i <= 50) {
		$('.circle_right').css({
			'transform': 'rotate(' + i * 3.6 + 'deg)',
			"background": "#eee"
		});
		$('.circle_left').css("transform", "rotate(0deg)");
	} else {
		$('.circle_right').css({
			'transform': 'rotate(0deg)',
			"background": "#FF4081"
		});
		$('.circle_left').css('transform', 'rotate(' + (i - 51) * 3.6 + 'deg)');
	}
}
//单击返回顶部按钮时
var uptop = document.getElementById("upTop");
uptop.onclick = function() { //点击图片时触发点击事件
	var i = 66;
	var timer = setInterval(function() { //设置一个计时器
		var ct = document.documentElement.scrollTop || document.body.scrollTop; //获取距离顶部的距离
		ct -= i;
		i= i++;
		console.log(i);
		if (ct > 0) { //如果与顶部的距离大于零
			window.scrollTo(0, ct); //向上移动66px
		} else { //如果距离小于等于零
			window.scrollTo(0, 0); //移动到顶部
			clearInterval(timer); //清除计时器
		}
	}, 10); //隔10ms执行一次前面的function，展现一种平滑滑动效果
}
function searchShow(){
	$('.search-fot').fadeIn("slow");
}
function getQueryString(name) { 
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i"); 
	var r = window.location.search.substr(1).match(reg); 
	if (r != null) return unescape(r[2]); return null; 
}
function startLoading(){
	$(".load").show();
	showOverlay(998);
}
function stopLoading(){
	$(".load").hide();
	hideOverlay();
}
function showOverlay(zIndez){
	if(zIndez == undefined) zIndez = 998;
	var overlay = '<div class="overlay" style="width: 100%; height: '+$(window).height()+'px; z-index: '+zIndez+'; background-color: rgba(44,44,44,0.66);"></div>';
	$('body').append(overlay);
}
function hideOverlay(){
	$('.overlay').remove();
}
function dialog(msg){
	showOverlay();
	var dialog = '<div class="dialog">\
		<div class="dialog-content">'+msg+'</div>\
		<footer class="dialog-footer">\
			<button class="btn-close" onclick="dialogClose()">关闭</button>\
		</footer>\
	</div>';
	$('body').append(dialog);
	$('.overlay').click(function(){
		dialogClose();
	});
}
function dialogClose(){
	hideOverlay();
	$('.dialog').fadeOut("slow");
	var dialog = setTimeout(function(){
		$('.dialog').remove();
		window.clearTimeout(dialog);
	},500);
}
function snackbar(msg){
	var snackbar = '<div class="dialog">\
	  <div class="dialog-content"><i class="mdui-icon material-icons">&#xe88f;</i>&nbsp;&nbsp;'+msg+'</div>\
	 </div>'
	$('body').append(snackbar);
	snackbar = setTimeout(function(){
		$('.dialog').remove();
		window.clearTimeout(snackbar);
	},3000);
}
function loading(num) {
	var snackbar = '<div class="dialog">\
	  <div class="dialog-content">\
		  <div class="spinner">\
			<div class="bounce1"></div>\
			<div class="bounce2"></div>\
			<div class="bounce3"></div>\
		</div>\
	</div>\
	 </div>'
	$('body').append(snackbar);
	if(num != undefined){
		snackbar = setTimeout(function(){
			$('.dialog').remove();
			window.clearTimeout(snackbar);
		},num*1000);
	}
}
document.write('<script src="./public/js/bg.js"></script>');