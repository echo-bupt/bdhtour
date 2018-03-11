<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>        
        <title>欢迎使用  后盾HD框架安装配置</title>
        <meta http-equiv="content-type" content="text/htm;charset=utf-8"/>  
        <link href='http://localhost/ymweb/hdphp/setup/./Tpl/State/Css/setup.css' rel='stylesheet' type='text/css'/>
        <script type='text/javascript' src='http://localhost/ymweb/hdphp/hdphp/../hdjs/jquery-1.8.2.min.js'></script>

    </head>

<div class="hd_setup">
    <strong>欢迎使用后盾HD框架，通过HD框架手册或登录<a href="http://bbs.houdunwang.com/">后盾论坛</a>学习使用HD框架安装配置</strong>

    <h2>
        <a href="<?php echo U('showaddnode',array('level'=>0));?>" target="_blank;">添加APP应用节点</a>&nbsp;&nbsp;&nbsp;
        <br/>
        <a href="http://localhost/ymweb/hdphp/setup/index.php?c=Rbac" class="home">返回安装首页</a>
        <a href="javascript:void(0)" class="home" onclick="window.close();return false;">关闭</a>
        <a href="<?php echo U('rbac/lock');?>" class="home">锁定SETUP应用</a>
    </h2>
</div>
<div class="setup">
    <div id="hd_rbac">
        <?php
        foreach($node as $v){ 
        ?>
        <h1><?php echo $v['title'];?><strong>(<?php echo $v['name'];?>)</strong>&nbsp;&nbsp;
            <a href="<?php echo U(showaddnode,array('nid'=>$v['nid'],'level'=>$v['level']));?>" style="font-size:14px;">
                <img src='http://localhost/ymweb/hdphp/setup/./Tpl/state/image/add.png' width='16' height='16'/>&nbsp;添加控制器
            </a>&nbsp;&nbsp;
            <a href="<?php echo U(delnode,array('nid'=>$v['nid']));?>" style="font-size:14px;">
                <img src='http://localhost/ymweb/hdphp/setup/./Tpl/state/image/remove.png' width='16' height='16'/>&nbsp;删除应用
            </a>
        </h1>
        <?php
        if(isset($v['node']) && is_array($v['node'])){
        foreach($v['node'] as $m){
        ?>
        <table>
            <thead>
            <tr>
                <th>
                    <?php echo $m['title'];?><strong>(<?php echo $m['name'];?>)</strong>
                    <a href="<?php echo U(showaddnode,array('nid'=>$m['nid'],'level'=>$m['level']));?>">
                        添加
                    </a>&nbsp;&nbsp;
                    <a href="<?php echo U(delnode,array('nid'=>$m['nid']));?>">
                        删除
                    </a>
                </th>
            </tr>
            </thead>
            <?php
            if(!empty($m['node'])){
            ?>
            <tbody>
            <tr>
                <td>
                    <ul>
                        <?php
                            foreach($m['node'] as $j){
                            ?>
                        <li>
                            <?php echo $j['title'];?><strong>(<?php echo $j['name'];?>)</strong>
                            <a href="<?php echo U('delnode',array('nid'=>$j['nid']));?>">
                                删除
                            </a>

                        </li>
                        <?php
                            }
                            ?>
                    </ul>
                </td>
            </tr>
            </tbody>
            <?php
            }
            ?>
        </table>
        <?php
            }}}
        ?>
    </div>

</div>

</body>
</html>
