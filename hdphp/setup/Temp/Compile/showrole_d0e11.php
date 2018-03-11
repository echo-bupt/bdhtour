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
        <a href="<?php echo U('addrole');?>" target="_self">添加角色</a>&nbsp;&nbsp;&nbsp;
        <br/>
        <a href="http://localhost/ymweb/hdphp/setup/index.php?c=Rbac" class="home">返回安装首页</a>
        <a href="javascript:void(0)" class="home" onclick="window.close();return false;">关闭</a>
        <a href="<?php echo U('rbac/lock');?>" class="home">锁定SETUP应用</a>
    </h2>
</div>
<div class="setup">
    <dl>
        <dt>用户角色（用户组）</dt>
        <dd>
            <table width="100%">
                <tr>
                    <td width="100">角色(组)ID</td>
                    <td>角色名称</td>
                    <td width="120">是否开启角色</td>
                    <td width="150">角色描述</td>
                    <td width="180">操作</td>
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
                        <td><?php echo $v['rid'];?></td>
                        <td><?php echo $v['rname'];?></td>
                        <td>
                            <?php if($v['state']){?>开启
                                <?php  }else{ ?>关闭
                            <?php }?>
                        </td>
                        <td><?php echo $v['title'];?></td>
                        <td>
                            <a href="<?php echo U('editroleshow',array('rid'=>$v['rid']));?>">编辑</a> |
                            <a href="<?php echo U('setaccess',array('rid'=>$v['rid']));?>">配置权限</a> |
                            <a href="<?php echo U('delrole',array('rid'=>$v['rid']));?>" onclick="return confirm('确认删除')">删除</a>&nbsp;&nbsp;&nbsp;
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
