---
title: ACG58动漫社区-2015届一栋5-8宿舍
date: 2018-10-01 16:36:38
tags: php
---
# 2015届一栋5-8宿舍
感觉以前写的实在是有点太丑,而且也一直没完善,最近就找了下空闲时间重构了一下代码
## 随便说下吧
首页遍历各个分类显示12个最新文章,所以分类都会遍历,分类每页显示30条数据,用户组 Admin管理员账户,后台用户信息修改暂时后台没写,首页轮播图admin用户组可进入/admin/acg下更改,关注用户暂未实现
<!-- more -->
##
文章发布,修改,删除;amdin用户组用户删除重置密码,修改轮播图,回复消息及文章删除;普通用户组消息回复,自己发布的文章修改删除.文章收藏,点赞等
## 搭建
    将文件解压到网站根目录,解压 acg58.sql.tar.gz数据库文件,新建数据库ACG导入数据,修改/public/sql.php文件,修改数据库账户密码
```php
$serverhost = 'localhost'; //数据库地址
$dbname = "acg"; //数据库名
$username = "root"; //数据库账户名
$password = "usbw"; //数据库密码
```
## 框架
    PHP: 原生PHP mysqli数据库链接
    前端: MDUI LayUI Jquery
    富文本: SummerNote
## 图片预览
![view](preview/1.jpg)
![view](preview/2.jpg)
![view](preview/3.jpg)
![view](preview/4.png)
![view](preview/5.jpg)
![view](preview/6.png)
## 反馈&建议
    随便那里说啦,大概我也不会弄咯
## About 5-8宿舍
    云南能源职业技术学院男生宿舍1栋5-8
    老孟 胖子 逗比 骚朱 骚翔
![view](preview/photo.jpg)

Copyright 2018-05

<script src="//libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script src="//tia.nos-eastchina1.126.net/public/viaplayer/viaplayerAll.js"></script>
<script>viaplayer.player(729837165)</script>
