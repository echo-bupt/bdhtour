<?php


//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓

//合作身份者id，以2088开头的16位纯数字

$aliapy_config['partner']      = "2088911526026806";



//安全检验码，以数字和字母组成的32位字符

$aliapy_config['key']          = "neeaxl3zqtivfiqh9zfojtg4w1gn5gvo";



//签约支付宝账号或卖家支付宝帐户

$aliapy_config['seller_email'] = "70248996@qq.com";



//页面跳转同步通知页面路径，要用 http://格式的完整路径，不允许加?id=123这类自定义参数

//return_url的域名不能写成http://localhost/create_direct_pay_by_user_php_utf8/return_url.php ，否则会导致return_url执行无效

$aliapy_config['return_url']   = __APP__."/order/returnHotelUrl";



//服务器异步通知页面路径，要用 http://格式的完整路径，不允许加?id=123这类自定义参数

$aliapy_config['notify_url']   = '';



//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑





//签名方式 不需修改

$aliapy_config['sign_type']    = 'MD5';



//字符编码格式 目前支持 gbk 或 utf-8

$aliapy_config['input_charset']= 'utf-8';



//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http

$aliapy_config['transport']    = 'http';

?>