<?php
class TicketControl extends CommonControl{
	function index()
	{
		$ticket=M("ticket")->order("time desc")->all();
		$count=count($ticket);
		$page=new page($count,16,5,2);
		$ticket=M("ticket")->limit($page->limit())->order("del desc,time desc")->all();
		$acoon=M("address");
		foreach ($ticket as $k => $v) {
			$aname=$acoon->where(array("aid"=>$v['aid']))->getField("aname");
			$ticket[$k]['aname']=$aname;
			$ticket[$k]['time']=date("Y-m-d H:i:s",$v['time']);
		}
		$page=$page->show();
		$this->assign("page",$page);
		$this->assign("ticket",$ticket);
		$this->display("index");
	}
	function add()
	{
		if(IS_GET)
		{
			$allLocality=M('address')->select();
			$allTypeData=M("type")->select();
			$time=date("Y-m-d H:i:s",time());
			$this->assign("time",$time);
			$this->assign("allTypeData",$allTypeData);
			$this->assign('allLocality',$allLocality);
			$this->display("add");
		}elseif(IS_POST)
		{
			$data=$_POST;
			$data['time']=strtotime($_POST['time']);
			$data['is_hui']=isset($_POST['is_hui'])?$_POST['is_hui']:0;
			$tid=M("ticket")->add($data);
			if($tid)
			{
				//接下来是添加与景点对应的图片信息。
				$index_img=isset($_POST['index_img'])?$_POST['index_img']:"";
				$img=isset($_POST['img'])?$_POST['img']:"";
				$pid=isset($_POST['pid'])?$_POST['pid']:"";
				$prices=isset($_POST['prices'])?$_POST['prices']:"";
				$tccon=M("ticket_type");
				$icoon=M('ticket_imgs');
				if($index_img)
				{
					foreach ($index_img as $k => $v) {
					$index_data=array("tid"=>$tid,"img"=>$v['thumb'][0],"time"=>time(),"alt"=>$v['alt'],"type"=>"1");
					$icoon->add($index_data);
				}
			}
				if($img){
						foreach ($img as $k => $v) {
				            $data=array("tid"=>$tid,"img"=>$v['thumb'][0],"time"=>time(),"alt"=>$v['alt'],"type"=>2);
				            $icoon->add($data);
						   }
				         }

			//接下来是添加门票类型:

			if($pid)
			{
				foreach ($pid as $k => $v) {
					if(!$prices[$k])
					{
						continue;
					}
					$data=array("tid"=>$tid,"pid"=>$v,"price"=>$prices[$k]);
					$tccon->add($data);
				}
			}
			}
			$this->success("添加成功!");
		}
	}
	function edit()
	{
		if(IS_GET)
		{
		$tid=$_GET['tid'];
		$ticket=M("ticket")->where(array("tid"=>$tid))->find();
		$ticket_type=M("ticket_type")->where(array("tid"=>$tid))->all();
		$allTypeData=M("type")->select();
		$allLocality=M("address")->all();
		$indexImg=M("ticket_imgs")->where(array("tid"=>$tid,"type"=>1))->field("img")->all();
		$detailImg=M("ticket_imgs")->where(array("tid"=>$tid,"type"=>2))->field("img")->all();
		$ticket['time']=date("Y-m-d H:i:s",$ticket['time']);
		$this->assign("ticket_type",$ticket_type);
		$this->assign("allTypeData",$allTypeData);
		$this->assign("allLocality",$allLocality);
		$this->assign("indexImg",$indexImg);
		$this->assign("detailImg",$detailImg);
		$this->assign("ticket",$ticket);
		$this->display("edit");
		}elseif(IS_POST){
			$data=$_POST;
			$data['tid']=$_POST['tid'];
			$tid=$_POST['tid'];
			$data['time']=strtotime($_POST['time']);
			M("ticket")->update($data);
			if(isset($_POST['img']) || isset($_POST['index_img']))
			{
				$icoon=M('ticket_imgs');
				//也就是有新的图片去更新，将原来的图片删掉
				//添加新的图片入库。
				$index_img=isset($_POST['index_img'])?$_POST['index_img']:"";
				$img=isset($_POST['img'])?$_POST['img']:"";
				if($index_img)
				{
				 	$res=$this->deleteImgByTid($_POST['tid'],1);
					if(!$res)
					{
						$this->error("删除图片有错误!");
					}
					foreach ($index_img as $k => $v) {
					$index_data=array("tid"=>$tid,"img"=>$v['thumb'][0],"time"=>time(),"alt"=>$v['alt'],"type"=>"1");
					$icoon->add($index_data);
				}
				}
				if($img)
				{
					$res=$this->deleteImgByTid($_POST['tid'],2);
					if(!$res)
					{
						$this->error("删除图片有错误!");
					}
					foreach ($img as $k => $v) {
						$data=array("tid"=>$tid,"img"=>$v['thumb'][0],"time"=>time(),"alt"=>$v['alt'],"type"=>"2");
						$icoon->add($data);
				}

			}
		}

		//接下来是更新票的类型:
		//先删除:
		$tccon=M("ticket_type");
		$tccon->where(array("tid"=>$tid))->delete();
		//再重新插入:
		$pid=isset($_POST['pid'])?$_POST['pid']:"";
		$prices=isset($_POST['prices'])?$_POST['prices']:"";
		if($pid)
			{
				foreach ($pid as $k => $v) {
					if(!$prices[$k])
					{
						continue;
					}
					$data=array("tid"=>$tid,"pid"=>$v,"price"=>$prices[$k]);
					$tccon->add($data);
				}
			}

		$this->success("修改成功!");
		}


	}
	function delete()
	{
		$tid=$_GET['tid'];
		//将门票以及对应的图片删掉
		$ires=$this->deleteImgByTid($tid);
		$tres=M("ticket")->where(array("tid"=>$tid))->delete();
		$tyres=M("ticket_type")->where(array("tid"=>$tid))->delete();
		if($ires && $tres && $tyres)
		{
			$this->success("删除成功!");
		}

	}
		function deleteImgByTid($tid,$type=0)
	{
		$coon=M("ticket_imgs");
		if($type==0)
		{
			$src=$coon->where(array("tid"=>$tid))->all();
		}else{
			$src=$coon->where(array("type"=>$type,"tid"=>$tid))->all();
		}
	if($src)
		{
		foreach($src as $k=>$v)
			{
				$info=pathinfo($v['img']);
				$img=substr($info['filename'], 0,strpos($info['filename'], "_")).".".$info['extension'];
				@unlink(ROOT_PATH.$v['img']);
				@unlink(ROOT_PATH."upload/".$img);
			}
		}

		//将数据库中的图片删除掉。
		if($type==0)
		{
			$coon->where(array("tid"=>$tid))->delete();
		}else{
			$coon->where(array("tid"=>$tid,"type"=>$type))->delete();
		}
		return true;
	}
}


?>