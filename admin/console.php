<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="../public/layui/css/layui.css"  media="all">
  <style type="text/css">
      a{text-decoration: none; color: #000;}
      body{ background-color: #eee; }
      .content{ text-align:center; margin-top: 15px;background-color: #eee;z-index: 9999}
      .icon{ display: inline-block; margin: 0 auto;  }
      .user-icon{ margin: 5px; width: 100px; height: 100px; border-radius: 50%; background-color: #EBEBEB; box-shadow:0px 0px 0px 5px #FFF; float: left}
      .user-name{ padding: 0 15px; font-size: 2rem; height: 105px; overflow:hidden; float: left; display:flex; display: -webkit-flex; align-items:center;/*指定垂直居中*/ }
      .user-info{ max-width: 400px; margin: 5px auto; font-size: 16px; font-weight: 500;  overflow:hidden; text-overflow: ellipsis; white-space: nowrap; opacity: .87; color: #333; border: dashed 1px #eee;}
      .user-info:hover{ overflow:hidden; text-overflow: clip; white-space: normal; z-index: 999; border: dashed 1px #ff4081; border-radius: 5px; }
      .user-nav{  margin-top: 15px; height: 42px; background-color: #fff; border-radius: 5px; }
      .user-nav > ul,ul>a{ padding: 0px; }
      a > li {display: inline-block; width: 19%; height: 42px; font-size: 1.5rem; line-height: 40px; align-items:center; }
      ul> a{ text-decoration: none; height: 42px; out-line: none; }
      a > li:hover,.active{background-color: rgba(255,40,81,.1);  border-bottom: 3px solid #ff4081; }
      .user{ width: 100%; position: relative; margin-top:35px}
      .user-title{position: absolute; top: -1rem; left: 1.5rem; display:inline-block; overflow:hidden;font-size: 1.1rem; color: #FFF; background-color: #0fb2fc; z-index: 999; border-radius: 3px;padding: 4px 8px}
      .user-content{width: 100%;background-color: hsla(0,0%,100%,.95); z-index: -1; border-radius: 5px; padding-top: 1rem;text-align: left}
      table{ margin: 5px 0; }
  </style>
</head>
<body>
  
  <div class="layui-fluid content">
        <!-- 头像显示区域 -->
        <div class="icon">
          <img  class="user-icon" src="../images/user/1.gif">
          <div class="user-name">Name</div>
        </div>
        <div class="user-info">这个人很高冷啊，啥也没留下</div> 
        <!-- nav导航区域 -->
        <nav class="user-nav">
          <ul>
            <a onclick="onUserInfo('个人资料','info');"  href="javascript:void(0);">
              <li>首页</li>
            </a>
            <a onclick="onUserInfo('文章','author');" href="javascript:void(0);">
              <li>文章</li>
            </a>
            <a onclick="onUserInfo('收藏','fav');" href="javascript:void(0);">
              <li>收藏</li>
            </a>
            <a onclick="onUserInfo('评论','comments');" href="javascript:void(0);">
              <li>评论</li>
            </a>
          </ul>
        </nav>
        <!-- 个人内容区域 -->
        <div class="user">
          <div class="user-title">个人资料</div>
          <div class="user-content"></div>
        </div>
  </div>
<div class="Copyright" style=" width: 190px; margin: 24px auto;"> <span>Copyright © 2018 <a href="//www.QiaTia.top">QiaTia</a></span></div>
<script src="//libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script type="text/javascript">
  var user=<?php SESSION_start(); echo $_SESSION['userId']?>;
     $(document).ready(function(){
        $.post('../user/submit.php',{
          userInfo:'user'
          ,user:user
        },function(data,status){
          data = JSON.parse(data);
          console.log(data);
          $('.user-name').html(data.name);
          $('.user-icon').attr("src",'../images/user/'+data.coer);
          $('.mdui-typo-title').html(data.name+'的个人空间--ACG58社区');
          document.title=data.name+'的个人空间 — ACG58社区'; 
        });
        onUserInfo('个人资料','info');
      });
    /*列表单击方法*/
      function onUserInfo(title,cate){
        $.post('../user/submit.php',{ tableCate:cate,user:user},function(data,status){ $('.user-content').html(data); $('.user-title').html(title); });
      }
</script>
</body>
</html>