<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>        
        <title>欢迎使用  后盾HD框架安装配置</title>
        <meta http-equiv="content-type" content="text/htm;charset=utf-8"/>  
        <link href='http://localhost/ymweb/hdphp/setup/./Tpl/State/Css/setup.css' rel='stylesheet' type='text/css'/>
        <script type='text/javascript' src='http://localhost/ymweb/hdphp/hdphp/../hdjs/jquery-1.8.2.min.js'></script>

    </head>

<body>
    <div class="hd_setup">
        <strong>欢迎使用后盾HD框架，通过HD框架手册或登录
            <a href="http://bbs.houdunwang.com/">后盾论坛</a>学习使用后盾HD框架
        </strong>
        <h2>
            <a href="http://localhost/ymweb/hdphp/setup/index.php?c=Rbac" class="home">返回安装首页</a>
            <a href="javascript:void(0)"  class="home" onclick="window.close();return false;">关闭</a>
            <a href="<?php echo U('rbac/lock');?>" class="home">锁定SETUP应用</a>
        </h2>
    </div>
    <div class="setup">
        <dl>
            <dt>RBAC表配置</dt>
            <dd><a href="<?php echo U('/rbac/setconfig');?>">配置RBAC表参数</a></dd>
            <dd><a href="<?php echo U('/rbac/createrbactable');?>">安装RBAC数据库表</a></dd>
        </dl>
        <?php if(C('RBAC_DB_SET')){?>
        <dl>
            <dt>RBAC用户&用户组设置</dt>
            <dd><a href="<?php echo U('/rbac/showrole');?>" >查看用户组</a></dd>
            <dd><a href="<?php echo U('/rbac/addrole');?>" >添加用户组</a></dd>
            <dd><a href="<?php echo U('/rbac/showuser');?>" >查看用户</a></dd>
            <dd><a href="<?php echo U('/rbac/showadduser');?>" >添加用户</a></dd>
        </dl>
        <dl>
            <dt>权限节点设置</dt>
            <dd><a href="<?php echo U('/rbac/shownode');?>" >查看节点信息</a></dd>
            <dd><a href="<?php echo U('/rbac/showaddnode');?>" >添加权限节点</a></dd>
        </dl>
        <?php }?>
    </div>
    <div style='color:#f00;font-size:14px; font-weight:bold;border:solid 1px #f00;padding:8px;width:600px; margin-left:20px;'>
        严重：当前系统开启框架安装模式，上线后将setup目录改名或删除！
    </div>
</body>
</html>