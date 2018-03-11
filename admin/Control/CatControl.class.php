<?php
class CatControl extends CommonControl{
	function index()
	{
		$catData=M("room_cat")->order("time desc")->all();
		foreach ($catData as $k => $v) {
			$catData[$k]['time']=date("Y-m-d H:i:s",$v['time']);
		}
		$this->assign("catData",$catData);
		$this->display("index");
	}
	function add()
	{
		if(IS_GET)
		{
			$this->display("add");
		}elseif(IS_POST)
		{
			$data=$_POST;
			$data['time']=time();
			$cid=M("room_cat")->add($data);
			if($cid)
			{
				$this->success("添加成功!");
			}
		}
	}
	function edit()
	{
		if(IS_GET)
		{
			$cid=$_GET['cid'];
			$cData=M("room_cat")->where(array("cid"=>$cid))->find();
			$this->assign("cData",$cData);
			$this->display("edit");
		}elseif(IS_POST)
		{
			$data=$_POST;
			$data['time']=time();
			$cid=M("room_cat")->update($data);
			if($cid)
			{
				$this->success("修改成功!");
			}
		}
	}
	function delete()
	{
		$cid=$_GET['cid'];
		$res=M("room_cat")->where(array("cid"=>$cid))->delete();
		if($res)
		{
			$this->success("删除成功!");
		}
	}
}



?>