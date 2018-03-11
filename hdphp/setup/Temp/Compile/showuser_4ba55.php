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
        <a href="<?php echo U('showadduser');?>" target="_self">添加用户</a>&nbsp;&nbsp;&nbsp;
        <a href="<?php echo U('showrole');?>" target="_self">查看用户组(角色)</a>&nbsp;&nbsp;&nbsp;
        <br/>
        <a href="http://localhost/ymweb/hdphp/setup/index.php?c=Rbac" class="home">返回安装首页</a>
        <a href="" class="home" onclick="window.close();return false;">关闭</a>
        <a href="<?php echo U('rbac/lock');?>" class="home">锁定SETUP应用</a>
    </h2>
</div>
<div class="setup">
    <dl>
        <dt>用户列表</dt>
        <dd>
            <table width="100%">
                <tr>
                    <td width="100">用户ID</td>
                    <td>用户名称</td>
                    <td width="200">所属组</td>
                    <td width="100">操作</td>
                </tr>
                <?php $hd["list"]["v"]["total"]=0;if(isset($row) && !empty($row)):$_id_v=0;$_index_v=0;$lastv=min(1000,count($row));
$hd["list"]["v"]["first"]=true;
$hd["list"]["v"]["last"]=false;
$_total_v=ceil($lastv/1);$hd["list"]["v"]["total"]=$_total_v;
$_data_v = array_slice($row,0,$lastv);
if(count($_data_v)==0):echo "";
else:
foreach($_data_v as $key=>$v):
if(($_id_v)%1==0):$_id_v++;else:$_id_v++;continue;endif;
$hd["list"]["v"]["index"]=++$_index_v;
if($_index_v>=$_total_v):$hd["list"]["v"]["last"]=true;endif;?>

                    <tr>
                        <td><?php echo $v['uid'];?></td>
                        <td><?php echo $v['username'];?></td>
                        <td><?php echo $v['role'][0]['title'];?></td>
                        <td>
                            <a href="<?php echo U('deluser',array('uid'=>$v['uid']));?>">删除</a>&nbsp;&nbsp;&nbsp;
                        </td>
                    </tr>
                <?php $hd["list"]["v"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>

            </table>
        </dd>
    </dl>
</div>
</body>
</html>
