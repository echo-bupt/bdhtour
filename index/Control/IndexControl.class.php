<?php
//测试控制器类
class IndexControl extends CommonControl{
  function __init()
  {
        $data=$this->getArticle();
        $this->assign("article",$data);
  }
    function index(){
        $tehuiData=$this->getHuidata(0);
        $tehuiHotel=$this->getHuidata(1);
        $tehuiTicket=$this->getHuidata(2);
        $hotelData=$this->getHotelData(0,0,true);
        $ticketData=$this->getTicketData(0,false,true);
        $this->assign("tehuiData",$tehuiData);
        $this->assign("tehuiHotel",$tehuiHotel);
        $this->assign("tehuiTicket",$tehuiTicket);
        $this->assign("ticketData",$ticketData);
        $this->assign("hotelData",$hotelData);
    	$this->display('index');
    }
    function detail()
    {
      $hid=$_GET['hid'];
      $hotel=M("hotel")->where(array("hid"=>$hid))->field("hid,hname,des,rel_ad")->find();
      $detailImgs=M("hotel_imgs")->where(array("hid"=>$hid,"type"=>2))->order("time asc")->field("img")->limit(4)->select();
      $yuanimg=$detailImgs[0];
      $detailImgs=array_splice($detailImgs, 1,3);
      $rooms=M("hotel_room")->where(array("hid"=>$hid))->all();
      $coon=M("room_cat");
      foreach ($rooms as $k => $v) {
        $room[$v['cid']]=$v;
        $cname=$coon->where(array("cid"=>$v['cid']))->getField("cname");
        $room[$v['cid']]["cname"]=$cname;
      }
      ksort($room);
      $this->assign("rooms",$room);
      $this->assign("hotel",$hotel);
      $this->assign("yuanimg",$yuanimg);
      $this->assign("detailImgs",$detailImgs);
    	$this->display("detail");
    }

    function artail()
    {
      $aid=$_GET['aid'];
      $data=M("article")->where(array("aid"=>$aid))->find();
      $orther=M("article")->order("click desc")->limit(15)->all();
      foreach($orther as $k=>$v)
        { if(strlen($v['title'])>45)
            {
              $orther[$k]['title']=substr($v['title'],0,45)."...";
            }
          
        }
      M("article")->inc("click","aid=$aid",1);
      p(M("article")->getLastSql());
      $this->assign("data",$data);
      $this->assign("orther",$orther);
      $this->display("article_detail.html");
    }
    function art_lies()
    {
      $count=M("article")->count();
      $page=new page($count,15,5,1);
      $data=M("article")->order("time desc")->limit($page->limit())->all();
      $orther=M("article")->order("click desc")->limit(15)->all();
      foreach($orther as $k=>$v)
        {
         if(strlen($v['title'])>45)
            {
              $orther[$k]['title']=substr($v['title'],0,45)."...";
            }
          
        }
      $this->assign("page",$page->show());
      $this->assign("orther",$orther);
      $this->assign("data",$data);
      $this->display("article.html");
    }
    function getHotel()
    {
    	//测试使用裁剪的还是 源图进行缩小??
    	if(IS_AJAX)
    	{
            $aid=$_POST['aid'];
            $htype=$_POST['htype'];
            $lei=isset($_POST['lei'])?$_POST['lei']:1;
            if($lei==2)
            {
              $hotelData=$this->getHotelData($aid,$htype,true);
                if($hotelData)
              {
                $this->assign("hotelData",$hotelData);
                $this->display("biaolie_2");
                 }else{
                echo "暂时没有数据";
              }
            }else{
                $hotelData=$this->getHotelData($aid,1,false);
                if($hotelData)
              {
                $this->assign("hotelData",$hotelData);
                $this->display("hotel");
                 }else{
                echo "暂时没有数据";
              }
            }


    	}
    }
    function getTicket()
    {
   if(IS_AJAX)
        {
            $aid=$_POST['aid'];
            $lei=isset($_POST['lei'])?$_POST['lei']:1;
            if($lei==2)
            {
              $ticketData=$this->getTicketData($aid,true);
                if($ticketData)
              {
                $this->assign("ticketData",$ticketData);
                $this->display("biaolie_3");
                 }else{
                echo "暂时没有数据";
              }
            }else{
                $ticketData=$this->getTicketData($aid,false);
                if($ticketData)
              {
                $this->assign("ticketData",$ticketData);
                $this->display("ticket");
                 }else{
                echo "暂时没有数据";
              }
            }
        }
    }
    //特惠
    function getHuidata($type)
    {
        $hotel= M("hotel")->where(array("is_hui"=>1))->order("time desc")->field("hname,hid,tprice")->limit(3)->all();
        $ticket=M("ticket")->where(array("is_hui"=>1))->order("time desc")->field("tname,tid,tprice")->limit(3)->all();
        if($type==0)
        {
            $res[]=isset($hotel[0])?$hotel[0]:array();
            $res[]=isset($hotel[1])?$hotel[1]:array();
            $res[]=isset($ticket[0])?$ticket[0]:array();
            if($res)
            {
                $Icoon=M("hotel_imgs");
                $Tcoon=M("ticket_imgs");
                foreach ($res as $k => $v) {
                if(isset($v['hid']))
                {
 $img=$Icoon->where(array("type"=>1,"hid"=>$v['hid']))->order("time desc")->field("hid,img,alt")->find();
  $res[$k]['img']=$img['img'];
  $res[$k]['alt']=$img['alt'];
  $res[$k]["key"]="hid";
  $res[$k]["val"]=$v['hid'];
  $res[$k]['name']=$v['hname'];
  $res[$k]['control']="index";
              }elseif(isset($v['tid'])) {
 $img=$Tcoon->where(array("type"=>1,"tid"=>$v['tid']))->order("time desc")->field("tid,img,alt")->find();
   $res[$k]['img']=$img['img'];
   $res[$k]["key"]="tid";
    $res[$k]['alt']=$img['alt'];
    $res[$k]["val"]=$v['tid'];
    $res[$k]['name']=$v['tname'];
    $res[$k]['control']="ticket";
                }
            }         
            return $res;
         }
        }elseif($type==1){
            if($hotel)
            {
                $Icoon=M("hotel_imgs");
            foreach ($hotel as $k => $v) {
                $img=$Icoon->where(array("type"=>1,"hid"=>$v['hid']))->order("time desc")->field("hid,img,alt")->find();
/*              $info=pathinfo($img['img']);
                $newimg=substr($img['img'], 0,strpos($img['img'],"_")).".".$info['extension'];*/
                $hotel[$k]['img']=$img['img'];
                $hotel[$k]['alt']=$img['alt'];
            }
            return $hotel;
            }
        }else{
                  $Icoon=M("ticket_imgs");
            foreach ($ticket as $k => $v) {
                $img=$Icoon->where(array("type"=>1,"tid"=>$v['tid']))->order("time desc")->field("tid,img,alt")->find();
/*              $info=pathinfo($img['img']);
                $newimg=substr($img['img'], 0,strpos($img['img'],"_")).".".$info['extension'];*/
                $ticket[$k]['img']=$img['img'];
                $ticket[$k]['alt']=$img['alt'];
            }
            return $ticket;
            }
        }

        //更多
        function more()
        {
            if($_GET['type']==0)
            {
                $data['poname']="今日特惠";
                $data['descri']="今日特惠列表";
                $tehuiData=$this->getAllhui();
                $page=new page(count($tehuiData),16,5,2);
                $exp=explode(",", $page->limit()['limit']);
                $length=$exp[1]-$exp[0];
                $tehuiData=array_slice($tehuiData,$exp[0],$length);
                $page=$page->show();
                $this->assign("page",$page);
                $this->assign("data",$data);
                $this->assign("tehuiData",$tehuiData);
                $this->display("liebiao.html");
            }elseif($_GET['type']==1)
            {
                //type=1
                //酒店类型。
                $htype=isset($_GET['htype'])?$_GET['htype']:1;
                  switch ($htype) {
                        case 1:
                     $data['poname']="宾馆酒店";
                     $data['descri']="宾馆酒店列表";
                     break;
                        case 2:
                    $data['poname']="家庭旅馆";
                    $data['descri']="家庭旅馆酒店列表";
                    break;
                        case 3:
                    $data['poname']="度假别墅";
                    $data['descri']="度假别墅酒店列表";
                    }
                    $data['htype']=$htype;
                //type=1&htype=1&aid=1
                if(isset($_GET['aid']))
                {
                     $hotelData=$this->getHotelData($_GET['aid'],$htype,true);
                     $this->assign("data",$data);
                     $this->assign("hotelData",$hotelData);
                    //type
                    //某种类型下并且是某种地区下的列表，没有更多的选项!
                    $this->display("hotel_lies");
                }else{
                    //这里是 点击顶级栏目与更多时:
                    //默认更多是全部酒店。
                     $hotelData=$this->getHotelData(1,$htype,true);
                     $this->assign("htype",$htype);
                     $this->assign("data",$data);
                     $this->assign("hotelData",$hotelData);
                     $this->display("biaolie.html");
                }

            }else{
                     $data['poname']="景点门票";
                     $data['descri']="旅游景点门票列表";
              if(isset($_GET['aid']))
                {
                    //type==2&aid=1
                     $ticketData=$this->getTicketData($_GET['aid'],true);
                     $this->assign("data",$data);
                     $this->assign("ticketData",$ticketData);
                    //某种类型下并且是某种地区下。
                     $this->display("ticket_lies");
                }else{
                    //这里是 点击顶级栏目与更多时: 
                    //type=2
                     $ticketData=$this->getTicketData(2,true,false);
                     $this->assign("data",$data);
                     $this->assign("topTicketData",$topTicketData);
                     $this->assign("ticketData",$ticketData);
                     $this->display("ticket_more.html");
                    }

                }
            }

    function getHotelData($aid,$type=1,$page=false)
    {
        if($page)
        {
          if($aid==0)
          {
 $hotelData=M("hotel")->order("time desc")->field("hid,hname,tprice,type")->limit(8)->select();
          }else{
                        //这是的酒店是全部的，不是分类的宾馆酒店!所以不按照type=1来弄
            $count=M("hotel")->where(array("aid"=>$aid,"type"=>$type))->count();
            $hotelData=M("hotel")->where(array("aid"=>$aid,"type"=>$type))->order("time desc")->field("hid,hname,tprice,type")->select();
          }
 
        }else{
             //这是的酒店是全部的，不是分类的宾馆酒店!所以不按照type=1来弄
            $hotelData=M("hotel")->where(array("aid"=>$aid,"type"=>$type))->order("time desc")->field("hid,hname,tprice,type")->limit(8)->select();
        }
           
            //type=1表示 前台显示图片，理论上只是一张，如果多张按时间排序取一张。
            $Icoon=M("hotel_imgs");
            foreach ($hotelData as $k => $v) {
                $img=$Icoon->where(array("type"=>1,"hid"=>$v['hid']))->order("time desc")->field("hid,img")->find();
/*              $info=pathinfo($img['img']);
                $newimg=substr($img['img'], 0,strpos($img['img'],"_")).".".$info['extension'];*/
                $hotelData[$k]['img']=$img['img'];
            }
            return $hotelData;
    }
    //$pagr=false 表示不分页，用于首页。
    function getTicketData($aid,$next=false,$page=false)
    {
            if($page)
        {
          if($aid==0)
          {
             $ticketData=M("ticket")->order("time desc")->field("tid,tname,price,man,descri,tprice")->limit(3)->select();
           }
        }else{
          if($next)
          {
            $limit=6;
          }else{
            $limit=3;
          }
             //这是的酒店是全部的，不是分类的宾馆酒店!所以不按照type=1来弄
            $ticketData=M("ticket")->where(array("aid"=>$aid))->order("time desc")->field("tid,tname,price,man,descri,tprice")->limit($limit)->select();
        }
            //type=1表示 前台显示图片，理论上只是一张，如果多张按时间排序取一张。
            $Icoon=M("ticket_imgs");
            foreach ($ticketData as $k => $v) {
                $img=$Icoon->where(array("type"=>1,"tid"=>$v['tid']))->order("time desc")->field("tid,img")->find();
/*              $info=pathinfo($img['img']);
                $newimg=substr($img['img'], 0,strpos($img['img'],"_")).".".$info['extension'];*/
                $ticketData[$k]['img']=$img['img'];
            }
            return $ticketData;    
    }
    function getAllhui()
    {
          $hotel= M("hotel")->where(array("is_hui"=>1))->order("time desc")->field("hname,hid,tprice")->all();
           $ticket=M("ticket")->where(array("is_hui"=>1))->order("time desc")->field("tname,tid,tprice")->all();
           $res=array_merge($hotel,$ticket);
         if($res)
                    {
                $Icoon=M("hotel_imgs");
                $Tcoon=M("ticket_imgs");
                foreach ($res as $k => $v) {
                if(isset($v['hid']))
                {
 $img=$Icoon->where(array("type"=>1,"hid"=>$v['hid']))->order("time desc")->field("hid,img")->find();
  $res[$k]['img']=$img['img'];
  $res[$k]["key"]="hid";
  $res[$k]["val"]=$v['hid'];
  $res[$k]['name']=$v['hname'];
              }elseif(isset($v['tid'])) {
 $img=$Tcoon->where(array("type"=>1,"tid"=>$v['tid']))->order("time desc")->field("tid,img")->find();
   $res[$k]['img']=$img['img'];
   $res[$k]["key"]="tid";
    $res[$k]["val"]=$v['tid'];
    $res[$k]['name']=$v['tname'];
                }
         }
    }
                return $res;
}
//联系我们
        function contact()
        {
          $this->display("contact.html");
        }
        function getTopTicket()
        {
         $ticketData=M("ticket")->order("time desc")->field("tid,tname,tprice,price,descri,man")->limit($limit)->select();
         $Icoon=M("ticket_imgs");
         $class=array("first","second","third");
            foreach ($ticketData as $k => $v) {
                $img=$Icoon->where(array("type"=>1,"tid"=>$v['tid']))->order("time desc")->field("tid,img")->find();
/*              $info=pathinfo($img['img']);
                $newimg=substr($img['img'], 0,strpos($img['img'],"_")).".".$info['extension'];*/
                $ticketData[$k]['img']=$img['img'];
                $ticketData[$k]['class']=$class[$k];
            }
           return $ticketData; 
        }
        function moreImg()
        {
          $hid=$_GET['hid'];
          $moreImg=M("hotel_imgs")->where(array("hid"=>$hid,"type"=>2))->all();
          $this->assign("moreImg",$moreImg);
          $this->display("moreImg");
        }
        function serach()
        {
          $tel=$_POST['tel'];
          $data1=M("order")->where(array("telephone"=>$tel,"state"=>array("neq"=>0)))->order("order_time desc")->all();
          $data2=M("ticket_order")->where(array("telephone"=>$tel,"state"=>array("neq"=>0)))->order("order_time desc")->all();
          if($data2)
          {
             $Icoon=M("ticket_imgs");
             $tcoon=M("ticket");
              foreach ($data2 as $k => $v) {
            $img=$Icoon->where(array("type"=>1,"tid"=>$v['tid']))->order("time desc")->field("tid,img")->find();
            $valid=$tcoon->where(array("tid"=>$v['tid']))->getField("valid");
                 $data2[$k]['img']=$img['img'];
                 $data2[$k]['valid']=$valid;
                 $data2[$k]['type']=unserialize($v['type']);
                 $data2[$k]['order_time']=date("Y-m-d H:i:s",$v['order_time']);
            if($v['state']==1)
              {
                $data2[$k]['state']="已支付,未处理";
              }elseif($v['state']==2)
              {
                 $data2[$k]['state']="已支付,已出票";
               }else{
                 $data2[$k]['state']="已支付,已退款";
               }
                }
           }
           if($data1)
           {
            $Icoon=M("hotel_imgs");
            foreach ($data1 as $k => $v) {
            $img=$Icoon->where(array("type"=>1,"hid"=>$v['hid']))->order("time desc")->field("hid,img")->find();
              $data1[$k]['order_time']=date("Y-m-d H:i:s",$v['order_time']);
              $data1[$k]['begin']=date("Y-m-d",$v['begin']);
              $data1[$k]['end']=date("Y-m-d",$v['end']);
              $data1[$k]['img']=$img['img'];
              if($v['state']==1)
              {
                $data1[$k]['state']="已支付，未处理";
              }elseif($v['state']==2)
              {
                 $data1[$k]['state']="已支付,已入住";
               }else{
                 $data1[$k]['state']="已支付,已退款";
               }
            }
           }
          $this->assign("hotel",$data1);
          $this->assign("ticket",$data2);
          $this->display("serach");
        }
     function getArticle()
        {
          $data=M("article")->order("time desc")->limit(5)->all();
          return $data;
        }
}
?>