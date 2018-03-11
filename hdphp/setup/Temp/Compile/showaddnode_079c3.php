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
        <a href="<?php echo U('shownode');?>">查看所有节点</a>
        <br/>
        <a href="http://localhost/ymweb/hdphp/setup/index.php?c=Rbac" class="home">返回安装首页</a>
        <a href="javascript:void(0)"  class="home" onclick="window.close();return false;">关闭</a>
        <a href="<?php echo U('rbac/lock');?>" class="home">锁定SETUP应用</a>
    </h2>
</div>
<form method="post" name="form1" id="form1" action="<?php echo U(addnode);?>">
    <input type="hidden" name="pid" value="<?php $_emptyVar =isset($_GET['nid'])?$_GET['nid']:null?><?php  if( empty($_emptyVar)){?>0<?php }else{ ?><?php echo $_GET['nid'];?><?php }?>"/>
    <div class="setup">
        <dl>
            <dt>添加节点</dt>
            <dd>
                <table>
                    <tr><td width="200">节点名称:</td>
                        <td>
                            <input type="text" name="name" id="name"/>
                        </td>
                    </tr>
                    <tr><td width="200">节点描述:</td>
                        <td>
                            <input type="text" name="title" id="title"/>
                        </td>
                    </tr>
                    <tr>
                        <td width="200">是否开启节点</td>
                        <td><input type="radio" name="state" id="state" value="1"  style="width:20px;" checked="checked"/> 开启
                            <input type="radio" name="state" id="state" value="0"  style="width:20px;"/> 关闭</td>
                    </tr>
                    <tr><td width="200">排序</td>
                        <td>
                            <input type="text" name="sort" id="sort" value="100"/>
                        </td>
                    </tr>
                    <tr><td width="200">节点等级</td>
                        <td>
                            <select name="level">
                                <?php $hd["list"]["k"]["total"]=0;if(isset($node) && !empty($node)):$_id_k=0;$_index_k=0;$lastk=min(1000,count($node));
$hd["list"]["k"]["first"]=true;
$hd["list"]["k"]["last"]=false;
$_total_k=ceil($lastk/1);$hd["list"]["k"]["total"]=$_total_k;
$_data_k = array_slice($node,0,$lastk);
if(count($_data_k)==0):echo "";
else:
foreach($_data_k as $key=>$k):
if(($_id_k)%1==0):$_id_k++;else:$_id_k++;continue;endif;
$hd["list"]["k"]["index"]=++$_index_k;
if($_index_k>=$_total_k):$hd["list"]["k"]["last"]=true;endif;?>

                                <option value="<?php echo $k['level'];?>"><?php echo $k['name'];?></option>
                                <?php $hd["list"]["k"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="200"><input type="submit" value="确认" class="query" name="submit"/></td>
                    </tr>
                </table>
            </dd>
        </dl>
    </div>
</form>
<script type="text/javascript">
     $("#form1").submit(function(){
        var stat = true;
        $("#name").next("span").remove();
        if($("#name").val()==''){
            stat = false;
            $("#name").after("<span>节点名称不能为空</span>");
        }
        $("#title").next("span").remove();
        if($("#title").val()==''){
            stat = false;
            $("#title").after("<span>节点描述不能为空</span>");
        }else if(!/^[\u4e00-\u9fa5\w]+$/.test($("#title").val())){
           stat = false;
            $("#title").after("<span>必须为中文</span>");
        }
        $("#sort").next("span").remove();
        if($("#sort").val()!='' &&!/^\d+$/.test($("#sort").val())){
             stat = false;
            $("#sort").after("<span>必须为数字</span>");
        }
        if(!stat)return false;
    })
</script>
</body>
</html>
