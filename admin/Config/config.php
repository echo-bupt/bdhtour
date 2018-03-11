<?php
if (!defined("HDPHP_PATH"))exit('No direct script access allowed');
//更多配置请查看hdphp/Config/config.php
$arr= array(
    /********************************验证码********************************/
    "CODE_FONT"                     => HDPHP_PATH . "Data/Font/font.ttf",       //字体
    "CODE_STR"                      => "123456789abcdefghijklmnpqrstuvwsyz", //验证码种子
    "CODE_WIDTH"                    => 90,         //宽度
    "CODE_HEIGHT"                   => 30,          //高度
    "CODE_BG_COLOR"                 => "#ffffff",   //背景颜色
    "CODE_LEN"                      => 4,           //文字数量
    "CODE_FONT_SIZE"                => 22,          //字体大小
    "CODE_FONT_COLOR"               => "",          //字体颜色
);
return array_merge(include './Conf/dbConfig.php',$arr);//array_merge可以将某个路径下的数组合并起来！这里的./应该是以index文件夹为标准的！

?>
