<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
    <?php
    include_once '../public/data.php';
    $id = isset($_GET['id'])?$_GET['id']:1;
    $info = sqlSelect('os','id',$id);
    SESSION_start();
    if($info['user_id']!=$_SESSION['userId']&&$_SESSION['vip']!='admin') die('<h2>Erro! this is not your article!</h2>');
    ?>
	<title>你正在修改<?php echo $info['title']?>--ACG58动漫社区</title>
	<link rel="stylesheet" href="//apps.bdimg.com/libs/bootstrap/3.3.4/css/bootstrap.min.css">
   <link href="//lib.baomitu.com/mdui/0.4.1/css/mdui.min.css" rel="stylesheet">
    <link href="dist/summernote.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="../public/css/public.css">
</head>
<body class="mdui-theme-primary-blue-grey">
	<div class="mdui-container">
        <form class="from">
                <div class="mdui-textfield mdui-textfield-floating-label">
                    <label class="mdui-textfield-label">标题,你分享的是什么</label>
                    <input class="mdui-textfield-input" maxlength="25" name="title" pattern="^.*(?=.{4,}).*$" type="text" value="<?php echo $info['title']?>" required/>
                    <div class="mdui-textfield-error">标题不能小于4位</div>
                </div>
                <div class="input mdui-textfield">
                    <label class="mdui-textfield-label">添加描述,让人对你的分享一幕了然</label>
                    <div class="input summernote"><?php echo $info['con']?></div>
                </div>

                <div class="mdui-col-xs-12">
                    <label class="mdui-textfield-label ">附加内容：下载</label>
                    <div class="mdui-textfield  mdui-col-xs-6">
                        <label class="mdui-textfield-label ">云盘下载地址</label>
                        <input class="mdui-textfield-input" maxlength="99" name="link" value="<?php echo $info['link']?>" type="text" />
                    </div>
                    <div class="mdui-textfield mdui-col-xs-3">
                        <label class="mdui-textfield-label">附加内容：提取码</label>
                        <input class="mdui-textfield-input" maxlength="14" name="link_code" value="<?php echo $info['link_code']?>" type="text" />
                    </div>
                    <div class="mdui-textfield mdui-col-xs-3">
                        <label class="mdui-textfield-label">附加内容：解压密码</label>
                        <input class="mdui-textfield-input" maxlength="14" name="link_code2" value="<?php echo $info['link_code2']?>" type="text" />
                    </div>
                </div>
                <div class="mdui-row-xs-2">
                    <div class="mdui-col">
                        <button class="mdui-btn mdui-btn-block mdui-color-theme mdui-ripple" id="submit" type="submit">提交修改</button>
                    </div>
                    <div class="mdui-col">
                        <a href="javascript:history.go(-1)" class="mdui-btn mdui-btn-block  mdui-color-theme mdui-ripple">取消修改</a>
                    </div>
                </div>
            </div>
        </div>

	<script src="//libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="//apps.bdimg.com/libs/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script src="dist/summernote.js"></script>
    <script src="dist/lang/summernote-zh-CN.js"></script>
    <script src="../public/js/public.js"></script>
	 <script type="text/javascript">
        var arrow_drop = 0;
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 350,
                tabsize: 2,
                lang: 'zh-CN'
            });
            $("#submit").click(function() {
                var content = $('.summernote').summernote('code')
                    ,title = $('input[name = title]').val();
                if(title == ''){
                    snackbar('请输入标题');
                    return 0;
                }
                $.post('submit.php',{
                    edit:'<?php echo $info['id']?>'
                    ,title:title
                    ,content:content
                    ,link:$('input[name = link]').val()
                    ,link_code:$('input[name = link_code]').val()
                    ,link_code2:$('input[name = link_code2]').val()
                },function(data){
                    dialog(data);
                });
            });
        });
        document.querySelector('#submit').addEventListener('click',function(e){
            e.preventDefault();
        },false);
    </script>
   <script src="//lib.baomitu.com/mdui/0.4.1/js/mdui.min.js"></script>
</body>
</html>