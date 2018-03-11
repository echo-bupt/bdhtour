<?php
class OrderControl extends CommonControl{
	  function __init()
  {
        $data=$this->getArticle();
        $this->assign("article",$data);
  }
	//填写订单 将填写订单与成功页面移到酒店页。根据返回数据去走不同的页面。
	function write()
	{
		$hid=$_GET['hid'];
		$cid=$_GET['cid'];
		$day=date("w");
		$name=M("hotel")->where(array("hid"=>$hid))->getField("hname");
		$price=M("hotel_room")->where(array("cid"=>$cid,"hid"=>$hid))->find();
		$cname=M("room_cat")->where(array("cid"=>$cid))->getField("cname");
		if($day==0 || $day==6)
		{
		$price['price']=$price['price_mo'];
		}else{
		$price['price']=$price['price_ping'];
		}
		$price['name']=$name;
		$price['cname']=$cname;
		$this->assign("price",$price);
		$this->display("write");
	}
	//支付
	function pay()
	{
	if(IS_POST) {
		if($_POST['price_type']==1)
		{
			$tel=$_POST['telephone'];
			M("order")->where(array("telephone"=>$tel))->getField("oid");
						//将订单数据写入数据库:
			foreach ($_POST['oname'] as $k => $v) {
				if($v)
				{
					$names.=$v.",";
				}		
			}
			$cid=$_POST['cid'];
			$hid=$_POST['hid'];
			$htype=M("hotel")->where(array("hid"=>$hid))->getField("type");
			 switch ($htype) {
                        case 1:
                     $data['poname']="宾馆酒店";
                     break;
                        case 2:
                    $data['poname']="家庭旅馆";
                    break;
                        case 3:
                    $data['poname']="度假别墅";
                    }
            $data['htype']=$htype;
			$cname=M("room_cat")->where(array("cid"=>$cid))->getField("cname");
			$data['myname']=substr($names, 0,strpos($names, ","));
			if(!($_POST['telephone']))
			{
				$this->error("请填写手机号");
			}
			$data['telephone']=$_POST['telephone'];
			$data['cname']=$cname;
			$data['oname']=rtrim($names,",");
			$data['name']=$_POST['name'];
			$data['onum']=$_POST['num'];
			$data['price_total']=$_POST['total_price'];
			$data['begin']=strtotime($_POST['updatetime']);
			$data['end']=strtotime($_POST['updatetime2']);
			$data['price']=$_POST['price'];
			$data['order_num']=time();
			//state=0表示提交未支付 1表示支付未处理 2表示已支付已处理
			$data['state']=0;
			$data['order_time']=time();
			$data['price_type']=$_POST['price_type'];
			$data['hid']=$hid;
			$data['cid']=$cid;
			$data['days']=$_POST['days'];
			M("order")->add($data);
			$this->assign("data",$data);
			$this->display("pay");
		}else{
			//门票的订单写入!
			$data['order_num']=time();
			$data['oname']=$_POST['oname'];
			$data['name']=$_POST['name'];
			$data['order_time']=time();
			$data['state']=0;
			$data['telephone']=$_POST['telephone'];
			$data['price_total']=$_POST['total_price'];
			$data['idnum']=$_POST['idnum'];
			//身份证以及票种信息。
			$pid=$_POST['pid'];
			$num=$_POST['num'];
			$price=$_POST['price'];
			$tid=$_POST['tid'];
			$data['tid']=$tid;
			$valid=M("ticket")->where(array("tid"=>$tid))->getField("valid");
			$valid=$valid?$valid:"一天";
			$data['valid']=$valid;
			$data['num']=array_sum($num);
			foreach ($pid as $k => $v) {
				if($num[$k]==0)
				{
					continue;
				}
				$type[$k]["pid"]=$v;
				$type[$k]['num']=$num[$k];
				$type[$k]['price']=$price[$k];
			}
			$type=serialize($type);
			$data['type']=$type;
			$this->assign("data",$data);
			p($data);
			exit();
			M("ticket_order")->add($data);
			$this->display("ticket_pay");
		}


		}

	}
	function getAply()
	{
		//由于是模板引擎进行解析!所以他会将常量解析的!不会当做变量来处理!所以只要是模板文件中的就用""来包围即可!
		//在PHP文件里面 系统常量一定要用大写,因为这是在单入口文件中定义的!不要加引号
		//由于最后都将文件载入到单入口文件，所以框架中的常量都能使用!
		header("Content-type:text/html;charset=utf-8");
		// ECHO __HOST__; 域名
		require_once(ROOT_PATH."index/config/alipay.config.php");

		require_once(ROOT_PATH."index/lib/alipay_service.class.php");

		/**************************请求参数**************************/
		//请与贵网站订单系统中的唯一订单号匹配
		$type=isset($_POST['price_type'])?$_POST['price_type']:1;
		if($type==2)
		{
			$aliapy_config['return_url']=__APP__."/order/returnTicketUrl";//注意常量大写不要加引号
		}
		$out_trade_no=$_POST['order_num'];
		//订单名称，显示在支付宝收银台里的“商品名称”里，显示在支付宝的交易管理的“商品名称”的列表里。
		$subject      =$_POST['name'];// $_POST['subject'];
		//订单描述、订单详细、订单备注，显示在支付宝收银台里的“商品描述”里
		$body         = "在线支付";//$_POST['alibody'];
		//订单总金额，显示在支付宝收银台里的“应付总额”里
		$total_fee    = $_POST['price_total'];//$_POST['total_fee'];


		//获取客户端的IP地址，建议：编写获取客户端IP地址的程序

		$exter_invoke_ip = '';

		//商品展示地址，要用 http://格式的完整路径，不允许加?id=123这类自定义参数

		$show_url			= __ROOT__;

		//自定义参数，可存放任何内容（除=、&等特殊字符外），不会显示在页面上

		$extra_common_param = '';


		//构造要请求的参数数组

		$parameter = array(

			//商户信息等
				"service"			=> "create_direct_pay_by_user",

				"payment_type"		=> "1",

				"partner"			=> trim($aliapy_config['partner']),

				"_input_charset"	=> trim(strtolower($aliapy_config['input_charset'])),

		        "seller_email"		=> trim($aliapy_config['seller_email']),

		        "return_url"		=> trim($aliapy_config['return_url']),

		        "notify_url"		=> trim($aliapy_config['notify_url']),

				//提交的!
				"out_trade_no"		=> $out_trade_no,

				"subject"			=> $subject,

				"body"				=> $body,

				"total_fee"			=> 0.01,

				"show_url"			=> $show_url,

				"extra_common_param"=> $extra_common_param,

		);
			//构造即时到帐接口

			$alipayService = new AlipayService($aliapy_config);

			$html_text = $alipayService->create_direct_pay_by_user($parameter);

			echo $html_text;



	}
	//酒店付款成功返回页面。
	function returnHotelUrl()
	{
		$order_num=$_GET['out_trade_no'];
		$occon=M("order");
		//修改一下状态:
		$occon->where(array("order_num"=>$order_num))->update(array("state"=>1));
		$orderInfo=$occon->where(array("order_num"=>$order_num))->find();
		$orderInfo['order_time']=date("Y-m-d H:i:s",$orderInfo['order_time']);
		$hid=$orderInfo['hid'];
		$tcoon=M("hotel");
		$tcoon->inc("del","hid=$hid",1);
		$cid=$orderInfo['cid'];
		$ad=M("hotel")->where(array("hid"=>$hid))->getField("rel_ad");
		$aid=M("hotel")->where(array("hid"=>$hid))->getField("aid");
		//附近景点信息。
         $ticketData=M("ticket")->where(array("aid"=>$aid))->order("time desc")->field("tid,tname,tprice")->limit(4)->select();
		 $Icoon=M("ticket_imgs");
            foreach ($ticketData as $k => $v) {
                $img=$Icoon->where(array("type"=>1,"tid"=>$v['tid']))->order("time desc")->field("tid,img")->find();
/*              $info=pathinfo($img['img']);
                $newimg=substr($img['img'], 0,strpos($img['img'],"_")).".".$info['extension'];*/
                $ticketData[$k]['img']=$img['img'];
            }
		$cname=M("room_cat")->where(array("cid"=>$cid))->getField("cname");
		$orderInfo['ad']=$ad;
		$orderInfo['cname']=$cname;
		$orderInfo['begin']=date("Y-m-d",$orderInfo['begin']);
		$orderInfo['end']=date("Y-m-d",$orderInfo['end']);
		$conname=$orderInfo['oname'];
		$name=substr($conname, 0,(strpos($conname, ",")===false)?strlen($conname):strpos($conname, ","));
		$orderInfo['conname']=$name;
		$this->assign("hotelData",$ticketData);
		$this->assign("order",$orderInfo);
		$this->display("returnHotelUrl.html");
	}
	function returnTicketUrl()
	{
		$order_num=$_GET['out_trade_no'];
		$occon=M("ticket_order");
		$occon->where(array("order_num"=>$order_num))->update(array("state"=>1));
		$ticket=M("ticket_order")->where(array("order_num"=>$order_num))->find();
		$tid=$ticket['tid'];
		$tcoon=M("ticket");
		$tcoon->inc("del","tid=$tid",1);
		$aid=M("ticket")->where(array("tid"=>$tid))->getField("aid");
		$valid=M("ticket")->where(array("tid"=>$tid))->getField("valid");
		$ticket['valid']=$valid;
		$ticket['order_time']=date("Y-m-d",$ticket['order_time']);
				//附近景点信息。
		 $hotelData=M("hotel")->where(array("aid"=>$aid))->order("time desc")->field("hid,hname,tprice,type")->limit(4)->select();
		 $Icoon=M("hotel_imgs");
            foreach ($hotelData as $k => $v) {
                $img=$Icoon->where(array("type"=>1,"hid"=>$v['hid']))->order("time desc")->field("hid,img")->find();
/*              $info=pathinfo($img['img']);
                $newimg=substr($img['img'], 0,strpos($img['img'],"_")).".".$info['extension'];*/
                $hotelData[$k]['img']=$img['img'];
            }
        $this->assign("ticketData",$hotelData);
		$this->assign("ticket",$ticket);
		$this->display("returnTicketUrl.html");
	}
}


?>