<?php
if (!defined("HDPHP_PATH"))exit('No direct script access allowed');

$arr=array();
return array_merge(include './Conf/dbConfig.php',$arr);//array_merge可以将某个路径下的数组合并起来！这里的./应该是以index文件夹为标准的！

?>
