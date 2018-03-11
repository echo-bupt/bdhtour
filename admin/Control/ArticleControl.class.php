<?php
class ArticleControl extends CommonControl{
	function index()
	{
		$count=M("article")->count();
		$page=new page($count,10,5,1);
		$data=M("article")->order("time desc")->all($page->limit);
		$this->assign("data",$data);
		$this->assign("page",$page->show());
		$this->display("index");
	}
	function add()
	{
		if(IS_GET)
		{
			$time=date("Y-m-d H:i:s",time());
			$this->assign("time",$time);
			$this->display("add");
		}else{
			$data=$_POST;
			M("article")->add($data);
			$this->success("添加成功!");
		}
	}
	function edit()
	{
		if(IS_GET)
		{
			$aid=$_GET['aid'];
			$cData=M("article")->where(array("aid"=>$aid))->find();
			$this->assign("data",$cData);
			$this->display("edit");
		}elseif(IS_POST)
		{
			$data=$_POST;
			$data['time']=date("Y-m-d H:i:s",time());
			$cid=M("article")->update($data);
			if($cid)
			{
				$this->success("修改成功!");
			}
		}
	}
		function delete()
	{
		$aid=$_GET['aid'];
		$res=M("article")->where(array("aid"=>$aid))->delete();
		if($res)
		{
			$this->success("删除成功!");
		}
	}
}


?>