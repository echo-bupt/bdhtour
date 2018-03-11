<?php
class HotelControl extends CommonControl{
	function index()
	{
		$type=$_GET['type'];
		$hotel=$this->getHotelData($type);
		$this->assign("type",$type);
		$this->assign("hotel",$hotel);
		$this->display('index');
	}
	function add()
	{
		if(IS_GET)
		{
			$type=$_GET['type'];
			$allLocality=M('address')->select();
			$allCatData=M("room_cat")->select();
			$this->assign("allCatData",$allCatData);
			$this->assign('allLocality',$allLocality);
			$time=date('Y-m-d H:i:s',time());
			$this->assign('time',$time);
			$this->assign('type',$type);
			$this->display('add');
		}elseif(IS_POST)
		{
			$hotel['hname']=$_POST['hname'];
			$hotel['type']=$_POST['type'];
			$hotel['aid']=$_POST['aid'];
			$hotel['price']=$_POST['price'];
			$hotel['old_price']=$_POST['old_price'];
			$hotel['des']=$_POST['detail'];
			$hotel['time']=strtotime($_POST['time']);
			$hotel['rel_ad']=$_POST['rel_ad'];
			$hotel['tprice']=$_POST['tprice'];
			$hotel['is_hui']=isset($_POST['is_hui'])?1:0;
			$coon=M('hotel');
			$hid=$coon->add($hotel);
			if($hid){
				$index_img=isset($_POST['index_img'])?$_POST['index_img']:"";
				$img=isset($_POST['img'])?$_POST['img']:"";
				$icoon=M('hotel_imgs');
				if($index_img)
				{
					foreach ($index_img as $k => $v) {
					$index_data=array("hid"=>$hid,"img"=>$v['thumb'][0],"time"=>time()+$k,"alt"=>$v['alt'],"type"=>"1");
					$icoon->add($index_data);
				}
			}
				if($img){
						foreach ($img as $k => $v) {
				            $data=array("hid"=>$hid,"img"=>$v['thumb'][0],"time"=>time()+$k,"alt"=>$v['alt'],"type"=>2);
				            $icoon->add($data);
						   }
				         }
				//这里添加酒店对应的房间类型。
			$cid=$_POST['cid'];
			$rcoon=M("hotel_room");
			foreach ($cid as $k => $v) {
				$price_shi=$_POST['price_shi'][$k];
				$price_ping=$_POST['price_ping'][$k];
				$price_mo=$_POST['price_mo'][$k];
				$device=$_POST['device'][$k];
				if(!$price_shi || !$price_ping || !$price_mo)
				{
					continue;
				}
				   	$room=array();
				   	$room['hid']=$hid;
				   	$room['cid']=$v;
				   	$room['price_shi']=$price_shi;
				   	$room['price_ping']=$price_ping;
				   	$room['price_mo']=$price_mo;
				   	$room['device']=$device;
				   	$rcoon->add($room);
				   }	   
			$this->success("添加成功!");
			}
			
		}
	
	}
	function edit()
	{
		if(IS_GET)
		{
			$type=$_GET['type'];
		    $hid=$_GET['hid'];
			$hotel=$this->getHotelData($type,$hid);
			$indexImg=M("hotel_imgs")->where(array("hid"=>$hid,"type"=>1))->field("img")->all();
			$detailImg=M("hotel_imgs")->where(array("hid"=>$hid,"type"=>2))->field("img")->all();
			$allLocality=M('address')->all();
			$allCatData=M("room_cat")->all();
			$allRoomData=M("hotel_room")->where(array("hid"=>$hid))->all();
			if($allRoomData)
			{
			   $this->assign("allRoomData",$allRoomData);
			}else{
				$this->assign("roomBtn",1);
			}
			$this->assign("indexImg",$indexImg);
			$this->assign("detailImg",$detailImg);
			$this->assign("allCatData",$allCatData);
			$this->assign('allLocality',$allLocality);
			$this->assign("type",$type);
			$this->assign("hotel",$hotel[0]);
			$this->display("edit");
		}elseif(IS_POST)
		{
				$data=$_POST;
				if(!isset($_POST['is_hui']))
				{
					$data['is_hui']=0;
				}
				$data['time']=strtotime($_POST['time']);
				$data['hid']=$_POST['hid'];
				$hid=$_POST['hid'];
				$data['des']=$_POST['detail'];
				unset($data['detail']);
				$re=M('hotel')->update($data);
			if(isset($_POST['img']) || isset($_POST['index_img']))
			{
				$icoon=M('hotel_imgs');
				//也就是有新的图片去更新，将原来的图片删掉
				//添加新的图片入库。
				$index_img=isset($_POST['index_img'])?$_POST['index_img']:"";
				$img=isset($_POST['img'])?$_POST['img']:"";
				if($index_img)
				{
				 	$res=$this->deleteImg($_POST['hid'],1);
					if(!$res)
					{
						$this->error("删除图片有错误!");
					}
					foreach ($index_img as $k => $v) {
					$index_data=array("hid"=>$hid,"img"=>$v['thumb'][0],"time"=>time(),"alt"=>$v['alt'],"type"=>"1");
					$icoon->add($index_data);
				}
				}
				if($img)
				{
					$res=$this->deleteImg($_POST['hid'],2);
					if(!$res)
					{
						$this->error("删除图片有错误!");
					}
					foreach ($img as $k => $v) {
						$data=array("hid"=>$hid,"img"=>$v['thumb'][0],"time"=>time(),"alt"=>$v['alt'],"type"=>"2");
						$icoon->add($data);
				}

			}
		}
		//接下来是房间类型的更改，将原有room删掉重新入库。
		$hid=$_POST['hid'];
		$rcoon=M("hotel_room");
		$rcoon->where(array("hid"=>$hid))->delete();
		$cid=$_POST['cid'];
		foreach ($cid as $k => $v) {
				$price_shi=$_POST['price_shi'][$k];
				$price_ping=$_POST['price_ping'][$k];
				$price_mo=$_POST['price_mo'][$k];
				$device=$_POST['device'][$k];
				if(!$price_shi || !$price_ping || !$price_mo)
				{
					continue;
				}
				   	$room=array();
				   	$room['hid']=$hid;
				   	$room['cid']=$v;
				   	$room['device']=$device;
				   	$room['price_shi']=$price_shi;
				   	$room['price_ping']=$price_ping;
				   	$room['price_mo']=$price_mo;
				   	$rcoon->add($room);
				   }	
			$this->success("修改成功!");
	}
}
	function delete()
	{
		$hid=$_GET['hid'];
		$res=M('hotel')->where(array("hid"=>$hid))->delete();
		//将对应的图片数据删掉,以及图片删掉。这里删除图片可作为一个函数调用。
		$dres=$this->deleteImg($hid);
		//删除相应的房间类型数据。
		$rres=M("hotel_room")->where(array("hid"=>$hid))->delete();
		if($res && $dres && $rres)
		{
			$this->success("删除成功!");
		}
	}
	function getHotelData($type,$hid=0)
	{
		$hotel=array();
		if($hid==0){
					$count=M('hotel')->order('time desc')->where(array("type"=>$type))->count();
					$page=new page($count,10,5,2);
					$hotel=M('hotel')->order('del desc,time desc')->where(array("type"=>$type))->all($page->limit());
					$page=$page->show();
					$this->assign("page",$page);
				}else{
					$hotel=M('hotel')->where(array("hid"=>$hid))->all();
				}
		$acoon=M("address");
		foreach ($hotel as $k => $v) {
			$aname=$acoon->where(array("aid"=>$v['aid']))->getField("aname");
			if($v['type']==1)
			{
				$hotel[$k]['tname']="宾馆酒店";
			}elseif($v['type']==2)
			{
				$hotel[$k]['tname']="家庭旅馆";
			}else{
				$hotel[$k]['tname']="度假别墅";
			}
			$hotel[$k]['aname']=$aname;
			$hotel[$k]['time']=date("Y-m-d H:i:s",$v['time']);
		}
		return $hotel;
	}
	function deleteImg($hid,$type=0)
	{
		$coon=M("hotel_imgs");
		if($type==0)
		{
			$src=$coon->where(array("hid"=>$hid))->all();
		}else{
			$src=$coon->where(array("type"=>$type,"hid"=>$hid))->all();
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
			$coon->where(array("hid"=>$hid))->delete();
		}else{
			$coon->where(array("hid"=>$hid,"type"=>$type))->delete();
		}
		return true;
	}
}

?>