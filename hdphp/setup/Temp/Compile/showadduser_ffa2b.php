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
        <a href="<?php echo U('showuser');?>" target="_self">查看用户列表</a>&nbsp;&nbsp;&nbsp;
        <a href="<?php echo U('showrole');?>" target="_self">查看用户组(角色)</a>&nbsp;&nbsp;&nbsp;
        <br/>
        <a href="http://localhost/ymweb/hdphp/setup/index.php?c=Rbac" class="home">返回安装首页</a>
        <a href="javascript:void(0)"  class="home" onclick="window.close();return false;">关闭</a>
        <a href="<?php echo U('rbac/lock');?>" class="home">锁定SETUP应用</a>
    </h2>
</div>
<form method="post" name="form1" id="form1" action="<?php echo U('adduser');?>">
    <input type="hidden" name="pid" value="<?php $_emptyVar =isset($_GET['pid'])?$_GET['pid']:null?><?php  if( empty($_emptyVar)){?>0<?php }else{ ?><?php echo $_GET['pid'];?><?php }?>"/>
    <div class="setup">
        <dl>
            <dt>添加用户</dt>
            <dd>
                <table>
                    <tr><td width="200">用户名称:</td>
                        <td>
                            <input type="text" name="username" id="username"/>
                        </td>
                    </tr>
                    <tr><td width="200">密码</td>
                        <td>
                            <input type="password" name="password" id="password"/>
                        </td>
                    </tr>
                    <tr><td width="200">所属组</td>
                        <td>
                            <select name="rid">
                                <?php $hd["list"]["v"]["total"]=0;if(isset($role) && !empty($role)):$_id_v=0;$_index_v=0;$lastv=min(1000,count($role));
$hd["list"]["v"]["first"]=true;
$hd["list"]["v"]["last"]=false;
$_total_v=ceil($lastv/1);$hd["list"]["v"]["total"]=$_total_v;
$_data_v = array_slice($role,0,$lastv);
if(count($_data_v)==0):echo "";
else:
foreach($_data_v as $key=>$v):
if(($_id_v)%1==0):$_id_v++;else:$_id_v++;continue;endif;
$hd["list"]["v"]["index"]=++$_index_v;
if($_index_v>=$_total_v):$hd["list"]["v"]["last"]=true;endif;?>

                                <option value="<?php echo $v['rid'];?>"><?php echo $v['title'];?></option>
                                <?php $hd["list"]["v"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
                            </select>
                        </td>
                    </tr>
                    <tr><td width="200"><input type="submit" value="确认" class="query" name="submit"/></td></tr>
                </table>
            </dd>
        </dl>
    </div>
</form>
<script type="text/javascript">
    $("#form1").submit(function(){
        var stat = true;
        $("#password").next("span").remove();
        if($("#password").val()==''){
            stat = false;
            $("#password").after("<span>密码不能为空</span>");
        }
        if(!stat)return false;
    })
</script>
</body>
</html>
