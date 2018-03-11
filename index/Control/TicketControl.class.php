<?php
class TicketControl extends CommonControl{
	  function __init()
  {
        $data=$this->getArticle();
        $this->assign("article",$data);
  }
	function index()
	{
		$this->display("index");
	}
		function detail()
	{
		$tid=$_GET['tid'];
		$ticket=M("ticket")->where(array("tid"=>$tid))->find();
		$detailImgs=M("ticket_imgs")->where(array("tid"=>$tid,"type"=>2))->order("time desc")->field("img")->limit(4)->select();
		$first=$detailImgs[0];
		$next=array_slice($detailImgs, 1,3);
		$this->assign("first",$first);
		$this->assign("next",$next);
		$this->assign("ticket",$ticket);
		$this->display("detail");
	}
	//填写订单
	function write()
	{
		$tid=$_GET['tid'];
		$ticket=M("ticket")->where(array("tid"=>$tid))->field("tid,tname,tprice,t1,t2,t3")->find();
		$ticket_type=M("ticket_type")->where(array("tid"=>$tid))->all();
		$count=0;
		foreach ($ticket_type as $k => $v) {
			$data[$v['pid']]=$v;
			$pname=M("type")->where(array("pid"=>$v['pid']))->getField("pname");
			$data[$v['pid']]["pname"]=$pname;
			$data[$v['pid']]['val']=0;
		}
		ksort($data);
		foreach ($data as $k => $v) {
			$data[$k]['key']=$count;
			$count++;
		}
		$data[1]['val']=1;
		// ksort($ticket_type,"")
		$this->assign("ticket_type",$data);
		$this->assign("ticket",$ticket);
		$this->display("write.html");
	}
	        function moreImg()
        {
          $tid=$_GET['tid'];
          $moreImg=M("ticket_imgs")->where(array("tid"=>$tid,"type"=>2))->all();
          $this->assign("moreImg",$moreImg);
          $this->display("moreImg");
        }
}


?>