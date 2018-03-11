<?php
//测试控制器类
class IndexControl extends CommonControl{
    function index(){
    	$data=array();
    	$coon=M('hotel')->db->link;
    	$this->display('index');
    }
    function copy(){
    	$this->display('copy');
    }
}
?>