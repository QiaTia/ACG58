layui.use('layedit', function(){
        layedit = layui.layedit
        ,$ = layui.jquery;
        //自定义工具栏
        index = layedit.build('edit', {
            tool: ['unlink', '|', 'left', 'center', 'right', '|', '|', '|', '|', 'face']
            ,height: 100
        })
});
repleCon(page);
function like() {
    if ($('.like').hasClass('color')) {
        snackbar('Erro!你只能👍一次哟');
        return 0;
    }
    startLoading();
    $.post('public/submit.php', {
        conId: conid,
        like: 'null'
    },function(data) {
        if (data != 0) dialog(data);
        else {
            $('.likeNum').html(parseInt($('.likeNum').html()) + 1);
            $('.like').addClass('color');
            dialog('谢谢的的支持');
        }
        stopLoading();
    })
}
function fav() {
    startLoading();
    $.post('public/submit.php', {
        conId: conid,
        fav: 'null'
    },
    function(data) {
        if (data === '0') {
            $('.favNum').html(parseInt($('.favNum').html()) + 1);
            $('.fav').addClass('color');
            dialog("成功加入收藏夹！");
        } else if (data === '1') {
            $('.favNum').html(parseInt($('.favNum').html()) - 1);
            $('.fav').removeClass('color');
            dialog("取消收藏成功！");
        } else {
            dialog(data)
        }
        stopLoading();
    })
}
function share(i,summary,pics) {
    var thisHref = window.location.href,
        shareTo,
        pics = 'https://'+window.location.host+'/'+pics;
    switch (i) {
    case 0:
        shareTo = "http://connect.qq.com/widget/shareqq/index.html?site="+title+"&title="+title+"&summary="+summary+"&pics="+pics+"&url="+thisHref;
        break;
    case 1:
        shareTo = 'http://service.weibo.com/share/share.php?url='+thisHref+'&title='+title+'&pic='+pics+'&searchPic=true'
        break;
    default:
        snackbar('Erro')
        return 0;
    }
    window.open(shareTo);
}
function reply() {
    var con = $('textarea[name = replycon]').val();
    $.post('public/submit.php', {
        conId: conid,
        reply: con
    },
    function(data) {
        if (data != '0') dialog(data);
        else {
            snackbar('回复成功！');
            $('textarea[name = replycon]').val('');
            repleCon(0);
        }
    });
}
function repleCon(page) {
    $.post('public/submit.php', {
        conId: conid,
        page: page
    },
    function(data) {
        $('.reply-Content-ul').html(data);
    });
}
function copy(msg,i){
    if (window.clipboardData) {
        window.clipboardData.clearData();
        clipboardData.setData("Text", msg);
        dialog('已复制，右键可粘贴');
    }else if(document.execCommand('copy')){
        var oInput = document.createElement('input');
        oInput.value = msg;
        document.body.appendChild(oInput);
        oInput.select(); // 选择对象
        document.execCommand("Copy"); // 执行浏览器复制命令
        oInput.className = 'oInput';
        oInput.style.display='none';
        dialog('已复制，右键可粘贴');
    }else{
        dialog('你的浏览器不兼容，请手动复制');
    }
}