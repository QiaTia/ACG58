<?php
include_once '../../public/data.php';
$i = isset($_GET['i'])?$_GET['i']:1;
$info = sqlSelect('banner','id',$i);
?>
<link rel="stylesheet" href="../../public/layui/css/layui.css"  media="all">
<style type="text/css">
	.layui-form-item>button,.layui-form-item>a{ width: 47vw;margin-left:0!important;float:right}
	.layui-form-item>button{float: left}
	form{padding:1vw}
	h3{text-align: center;margin-bottom:.5rem}
</style>
<form class="layui-form layui-form-pane" action="" >
	<h3>编辑&nbsp;<?php echo $info['title']?></h3>
	<div class="layui-form-item">
		<label class="layui-form-label">标题</label>
		<div class="layui-input-block">
			<input type="text" name="title" required  lay-verify="required" placeholder="请输入标题" class="layui-input" value="<?php echo $info['title']?>">
		</div>
	</div>
	<div class="layui-form-item">
		<label class="layui-form-label">连接</label>
		<div class="layui-input-block">
			<input type="text" name="href" required  lay-verify="required" placeholder="请输入连接地址" class="layui-input"  value="<?php echo $info['href']?>">
		</div>
	</div>
	<div class="layui-form-item">
		<label class="layui-form-label">图片</label>
		<div class="layui-input-block">
			<input type="text" name="img" required  lay-verify="required" placeholder="请选择图片" class="layui-input"  value="<?php echo $info['img-src']?>">
		</div>
	</div>
	<input type="hidden" name="edit" value="<?php echo $info['id']?>">
	<div class="layui-form-item">
		<button  lay-submit lay-filter="formDemo" id='submit' class="layui-btn">提交</button>
		<a href="javascript:{window.opener=null;window.open('','_self');window.close();};" class="layui-btn">取消</a>
	</div>
</form>
<script src="//libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script src="//cdn.90so.net/layui/2.2.6/layui.js " charset="utf-8"></script>
<script type="text/javascript">
	layui.use('form', function(){
	  var form = layui.form;
	  //监听提交
	  form.on('submit(formDemo)', function(data){
	    $.get('./submit.php',data.field,function(data){
	    	layer.msg(data);
	    });
	  	return false;
	  });
	});
	document.querySelector('#submit').addEventListener('click',function(e){
	    e.preventDefault();
	},false);
</script>