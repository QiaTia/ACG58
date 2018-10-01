<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>网站设置</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="../public/layui/css/layui.css"  media="all">
  <link rel="stylesheet" type="text/css" href="../public/css/public.css">
  <style type="text/css">
    .layui-card-body{min-height:66px}
    .coer{border-radius: 50%}
    .info{background-color:#eee; color:#222;padding:.5rem 1rem;margin-bottom: .5rem;border-radius:5px}
    #form1{display: inline-block;margin-left: .5rem;width: calc(100% - 120px) }
    .btn{background-color:#eee;color:#222;padding:1rem;width: 100%; border:2px dashed rgba(0,0,0,.1);height:88%;cursor:pointer;border-radius: 5px}
    .btn:hover{background-color: #FFF}
    .btn,button,input{transition:All .3s ease-in-out}
  </style>
</head>
<body>
<?php 
SESSION_start();  
$user = $_SESSION['userId'];
include_once '../public/data.php';
$info = sqlSelect('user','id',$user);
?>
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md9 layui-row layui-col-space15">
        <div class="layui-col-md6">
          <div class="layui-card">
            <div class="layui-card-header">我的头像</div>
            <div class="layui-card-body" pad15>
              <div class="info">上传成功即更改完成</div>
              <img class="coer" src="../images/user/<?php echo $info['coer']?>" alt="coer" width='100' height="100">
              <form id='form1'>
                <input type="button" class="btn" value="更改我的头像" onclick="file.click()" class="btn_mouseout"/> 
                <input type="file" id="file" name="file" onchange="upload(this);" style="display:none"/>  
              </form>
            </div>
          </div>
        </div>

        <div class="layui-col-md6">
          <div class="layui-card">
            <div class="layui-card-header">我的邮箱</div>
            <div class="layui-card-body" pad15>
              <div class="info">更改邮箱需要接受一封验证码填入下面验证是否为本人邮箱！请妥善保管邮箱，忘记密码或更改密码需要用到！</div>
              <div class="layui-form">
                <div class="layui-form-item">
                  <label class="layui-form-label">邮箱:</label>
                  <div class="layui-input-block">
                    <input type="text" name="email" placeholder="***@**.**" autocomplete="off" class="layui-input">
                  </div>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">验证码</label>
                  <div class="layui-input-block">
                    <input type="text" name="emailCode" placeholder="验证码" class="layui-input">
                  </div>
                </div>
                <div class="layui-input-block">
                  <button class="emailSu layui-btn layui-btn-disabled">更改邮箱地址</button>
                  <button class="emailCode layui-btn ayui-btn-sm layui-btn-disabled">发送验证码</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="layui-col-md6">
          <div class="layui-card">
            <div class="layui-card-header">个人资料</div>
            <div class="layui-card-body" pad15>
              <div class="layui-form">
                <div class="layui-form-item">
                  <label class="layui-form-label">用户名</label>
                  <div class="layui-input-block">
                    <input type="text" name="userName" placeholder="用户名无法更改" class="layui-input" disabled>
                  </div>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">签名:</label>
                  <div class="layui-input-block">
                    <textarea class="layui-textarea" name="userInfo" placeholder="这个娃特高冷，啥也没留下" style="resize:none;height:3.5rem">这个娃特高冷，啥也没留下</textarea>
                  </div>
                </div>
                <div class="layui-input-block">
                  <button class="infoSu layui-btn">更改个人信息</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="layui-col-md6">
          <div class="layui-card">
            <div class="layui-card-header">我的密码</div>
            <div class="layui-card-body" pad15>
              <div class="layui-form">
                <div class="layui-form-item">
                  <label class="layui-form-label">旧密码</label>
                  <div class="layui-input-block">
                    <input type="password" name="oldPw" placeholder="请验证旧密码" autocomplete="off" class="layui-input">
                  </div>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">新密码</label>
                  <div class="layui-input-block">
                    <input type="password" name="nPw" placeholder="新密码" class="layui-input">
                  </div>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">新密码</label>
                  <div class="layui-input-block">
                    <input type="password" name="rnPw" placeholder="请验证新密码" class="layui-input">
                  </div>
                </div>
                <div class="layui-input-block">
                  <button class="pwSu layui-btn layui-btn-disabled">更改密码</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="layui-col-md3">
        <div class="layui-card">
          <div class="layui-card-header">个人简述</div>
          <div class="layui-card-body userInfo"> </div>
        </div>
      </div>
    </div>
  </div>

<script src="../public/layui.js" charset="utf-8"></script>
<script src="//libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script src="../public/js/public.js"></script>
<script type="text/javascript">
  $.post('../user/submit.php',{ tableCate:'info',user:'<?php echo $user?>'},function(data,status){ $('.userInfo').html(data);});
  $(document).ready(function(){
        
    var pwIs = false,meter1,rNum,mailIs=false;
    $('input[name=email]').blur(function (){
      if(mailIs) return false;
      var reg = new RegExp("^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$"),
          inputMail = $(this).val();
      if(inputMail === ""){
        return false;
      }else if(!reg.test(inputMail)){ //正则验证不通过，格式不对
        return false;
      }else{
        $('.emailCode').removeClass('layui-btn-disabled');
        return true;
      }
    });
    $('.emailCode').click(function(){
      if($(this).hasClass('layui-btn-disabled')){
        return false;
      }
      var reg = new RegExp("^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$"),
          inputMail = $('input[name=email]').val();
      if(inputMail === ""){
        return false;
      }else if(!reg.test(inputMail)){ //正则验证不通过，格式不对
        dialog('你输入的邮箱格式不正确，请检查');
        $(this).addClass('layui-btn-disabled');
        return false;
      }
      loading();
      $.post('info.php',{emailCode:'emailCode',email:inputMail},function(){
        $('.emailCode').addClass('layui-btn-disabled');
        rNum= 60;
        mailIs = true;
        dialogClose();
        meter1 = setInterval(() => { reClick();},1000);
      });
      function reClick(){
          $('.emailCode').html(rNum+'秒后重试');
          rNum--;
          if(rNum<0) {
            clearInterval(meter1);
            mailIs = false;
            $('.emailCode').removeClass('layui-btn-disabled');
            $('.emailCode').html('重新发送验证码');
          }
        }
    });
    $('input[name=oldPw]').blur(function (){
      var oldPw = $(this).val();
      if(oldPw === ''){
        return false;
      }else{
        $.post('info.php',{oldPw:oldPw},function(data){
          if(data!='') {
            dialog(data);
            pwIs = false;
            return false;
          }else {
            pwIs = true;
            return true;
          }
        });
      }
    });
    $('input[name=rnPw]').blur(function (){
      var rnPw = $(this).val()
          ,nPw = $('input[name=nPw]').val();
      if(!pwIs){
        snackbar("输入密码不正确!");
        return false;
      }else if(rnPw === nPw){
        $('.pwSu').removeClass('layui-btn-disabled');
        return true;
      }else{
        dialog('两次输入的密码不一致，请检查后重试');
        return false;
      }
    });
    $('.pwSu').click(function(){
      if($(this).hasClass('layui-btn-disabled')){
        return false;
      }
      if(!pwIs){
        dialog('请先验证旧密码！');
        return false;
      }
      var oldPw = $('input[name=oldPw]').val()
          ,newPw = $('input[name=nPw]').val();
      loading();
      $.post('info.php',{oldPw:oldPw,newPw:newPw},function(data){
        dialogClose();
        dialog(data);
      })
    });
  });
  function upload(){  
    var animateimg = $("#file").val(); //获取上传的图片名 带//  
    var imgarr=animateimg.split('\\'); //分割  
    var myimg=imgarr[imgarr.length-1]; //去掉 // 获取图片名  
    var houzui = myimg.lastIndexOf('.'); //获取 . 出现的位置  
    var ext = myimg.substring(houzui, myimg.length).toUpperCase();  //切割 . 获取文件后缀  
      
    var file = $('#file').get(0).files[0]; //获取上传的文件  
    var fileSize = file.size,          //获取上传的文件大小  
        maxSize = 1048576;              //最大1MB  
    if(ext !='.PNG' && ext !='.GIF' && ext !='.JPG' && ext !='.JPEG'){  
        dialog('文件类型错误,请上传图片类型');  
        return false;  
    }else if(parseInt(fileSize) >= parseInt(maxSize)){  
        dialog('上传的文件不能超过1MB');  
        return false;  
    }else{    
        var data = new FormData($('#form1')[0]);  
        //console.log(data);
        $.ajax({    
            url: "info.php",   
            type: 'POST',    
            data: data,    
            dataType: 'JSON',    
            cache: false,    
            processData: false,    
            contentType: false    
        }).done(function(data){
            $('.coer').attr("src",data.filepath);
            if(data.isSuccess) dialog('上传成功'); else dialog('上传失败');  
        });    
        return false;  
       }    
    }  
</script>
</body>
</html>