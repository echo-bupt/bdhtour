<?php
class CommonControl extends Control{
	function __init()
	{
		//首先判断有没有过期，没有过期进行更新。过期删除。
		$coon=M("session");
		$info=$coon->order("time desc")->find();
		$this->assign("admin",$info);
		if($info['time']+1800<time())
		{
			 M()->truncate(array("jia_session"));
		}else{
			$coon->where(array("sid"=>$info['sid']))->update(array("time"=>time()));
		}
       if(empty($info))
      {
          go("login/index");
       }
    }
}