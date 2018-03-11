<?php
class LoginControl extends Control{
    public function index()
    {
        $this->display();
    }
    public function login()
{
    //验证都是通过用户名去查询数据库得到该用户的密码。与用户提交上来的密码进行比对！最终比较的是密码是否相等！
        if(!IS_POST)
        {
            $this->error("请求的页面不存在!");
        }
        $verify=strtoupper(($_POST['verify']));
        //注意在session里面存储的验证码是大写的！所以我们要将提交上来的数据进行大写处理！
        $username=$_POST["userName"];
        $userInfo=M("admin")->where(array("username"=>$username))->find();
        if($userInfo['lock']==1)
        {
            $this->error("对不起，您已经被锁定，请联系管理员");
        }
        $passwd=md5($_POST['psd']);
        if($passwd!=$userInfo['passwd'])
        {
            $this->error("用户名或者密码错误!");
        }
        //既然能走到这一步表示通过了验证，也就是这个用户存在，自然$userInfo不为空，如果之前$userInfo为空就走不到这一步了！自然不会通过验证了！

        //把用户信息写进session！
            // setcookie("session_name",$username,time()+1800,"/");
        $tres=M()->truncate(array("jia_session"));
        $data=array("sname"=>$username,"time"=>time());
        $ares=M("session")->add($data);
        if($tres && $ares)
        {
               $this->success("登陆成功!","index/index");     
           }
// go("index/index");
}
public function out()
{
    M()->truncate(array("jia_session"));
    $this->success("退出成功!","login/index");
}
}

?>
