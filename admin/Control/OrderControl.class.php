<?php
class OrderControl extends CommonControl{
	function indexAll()
	{
		$coon=M("order");
		$coon->where(array("state"=>0))->delete();
		$count=$coon->order("order_time desc")->count();
		$page=new page($count,10,5,2);
	     $order=$coon->order("order_time desc")->all($page->limit());
	     foreach ($order as $k => $v) {
				$order[$k]['order_time']=date("Y-m-d H:i:s",$v['order_time']);
				if($v['state']==1)
	              {
	                $order[$k]['state']="已支付,待处理";
	              }elseif($v['state']==2)
	              {
	                 $order[$k]['state']="已支付,已入住";
	               }else{
	                 $order[$k]['state']="已支付,已退款";
	               }
			}
      $page=$page->show();
      $this->assign("page",$page);
		$this->assign("order",$order);
		$this->display("index");
	}
	function ticketAll()
	{
		$coon=M("ticket_order");
		$coon->where(array("state"=>0))->delete();
		$count=$coon->order("order_time desc")->count();
	     $page=new page($count,10,5,2);
	     $order=$coon->order("order_time desc")->all($page->limit());
	     foreach ($order as $k => $v) {
				$order[$k]['order_time']=date("Y-m-d H:i:s",$v['order_time']);
					if($v['state']==1)
	              {
	                $order[$k]['state']="已支付,待处理";
	              }elseif($v['state']==2)
	              {
	                 $order[$k]['state']="已支付,已出票";
	               }else{
	                 $order[$k]['state']="已支付,已退款";
	               }
			}
      $page=$page->show();
      $this->assign("page",$page);
		$this->assign("order",$order);
		$this->display("ticket");
	}
	function indexToday()
	{
		$today=strtotime(date("Y-m-d"));
		$tommo=$today+86400;
		$coon=M("order");
		$coon->where(array("state"=>0))->delete();
		$order=$coon->where(array("order_time"=>array("elt"=>$tommo,"gt"=>$today)))->all();
		 $count=count($order);
	     $page=new page($count,10,5,2);
	     $order=$coon->where(array("order_time"=>array("elt"=>$tommo,"gt"=>$today)))->order("order_time desc")->all($page->limit());
	     foreach ($order as $k => $v) {
				$order[$k]['order_time']=date("Y-m-d H:i:s",$v['order_time']);
				if($v['state']==1)
	              {
	                $order[$k]['state']="已支付,待处理";
	              }elseif($v['state']==2)
	              {
	                 $order[$k]['state']="已支付,已入住";
	               }else{
	                 $order[$k]['state']="已支付,已退款";
	               }
			}
      $page=$page->show();
      $this->assign("page",$page);
		$this->assign("order",$order);
		$this->display("index");
	}
	function ticketToday()
	{
		$today=strtotime(date("Y-m-d"));
		$tommo=$today+86400;
		$coon=M("ticket_order");
		$coon->where(array("state"=>0))->delete();
		$order2=$coon->all();
	
		$order=$coon->where(array("order_time"=>array("elt"=>$tommo,"gt"=>$today)))->all();
		 $count=count($order);
	     $page=new page($count,10,5,2);
	     $order=$coon->where(array("order_time"=>array("elt"=>$tommo,"gt"=>$today)))->order("order_time desc")->all($page->limit());
	     foreach ($order as $k => $v) {
				$order[$k]['order_time']=date("Y-m-d H:i:s",$v['order_time']);
				if($v['state']==1)
	              {
	                $order[$k]['state']="已支付,待处理";
	              }elseif($v['state']==2)
	              {
	                 $order[$k]['state']="已支付,已出票";
	               }else{
	                 $order[$k]['state']="已支付,已退款";
	               }
			}
      $page=$page->show();
      $this->assign("page",$page);
		$this->assign("order",$order);
		$this->display("ticket");
	}
	function edit()
	{
		$oid=$_GET['oid'];
		$oData=M("order")->where(array("oid"=>$oid))->find();
		$oData['order_time']=date("Y-m-d H:i:s",$oData['order_time']);
		$oData['begin']=date("Y-m-d H:i:s",$oData['begin']);
		$oData['end']=date("Y-m-d H:i:s",$oData['end']);
		if($oData['state']==1)
	              {
	                $oData['state']="已支付,未处理";
	              }elseif($oData['state']==2)
	              {
	                 $oData['state']="已支付,已入住";
	               }else{
	                 $oData['state']="已支付,已退款";
	               }
		$this->assign("hotel",$oData);
		$this->display("edit");
	}
	function ticket_edit()
	{
		$oid=$_GET['oid'];
		$ticket=M("ticket_order")->where(array("oid"=>$oid))->find();
		$ticket['order_time']=date("Y-m-d H:i:s",$ticket['order_time']);
		$type=unserialize($ticket['type']);
		foreach ($type as $k => $v) {
			$pname=M("type")->where(array("pid"=>$v['pid']))->getField("pname");
			$type[$k]['pname']=$pname;
		}
		$valid=M("ticket")->where(array("tid"=>$ticket['tid']))->getField("valid");
		if($ticket['state']==1)
	              {
	                $ticket['state']="已支付,未处理";
	              }elseif($ticket['state']==2)
	              {
	                 $ticket['state']="已支付,已出票";
	               }else{
	                 $ticket['state']="已支付,已退款";
	               }
	    $ticket['valid']=$valid;
		$this->assign("ticket",$ticket);
		$this->assign("type",$type);
		$this->display("ticket_edit");
	}
	function chuli()
	{
		$oid=$_GET['oid'];
		$state=$_GET['state'];
		M("order")->update(array("state"=>$state,"oid"=>$oid));
		$this->success("处理成功!");
	}
	function chuli_ticket()
	{
		$oid=$_GET['oid'];
		$state=$_GET['state'];
		M("ticket_order")->update(array("state"=>$state,"oid"=>$oid));
		$this->success("处理成功!");
	}
	function delete()
	{
		$oid=$_GET['oid'];
		M("order")->where(array("oid"=>$oid))->delete();
		$this->success("删除成功!");
	}
	function ticket_delete()
	{
		$oid=$_GET['oid'];
		M("ticket_order")->where(array("oid"=>$oid))->delete();
		$this->success("删除成功!");
	}
}
?>