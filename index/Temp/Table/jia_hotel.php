<?php if(!defined('HDPHP_PATH'))exit;
return array (
  'hid' => 
  array (
    'field' => 'hid',
    'type' => 'int(8)',
    'null' => 'NO',
    'key' => true,
    'default' => NULL,
    'extra' => 'auto_increment',
  ),
  'type' => 
  array (
    'field' => 'type',
    'type' => 'int(8)',
    'null' => 'NO',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
  'hname' => 
  array (
    'field' => 'hname',
    'type' => 'varchar(16)',
    'null' => 'NO',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
  'tprice' => 
  array (
    'field' => 'tprice',
    'type' => 'int(8)',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
  'time' => 
  array (
    'field' => 'time',
    'type' => 'int(16)',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
  'is_hui' => 
  array (
    'field' => 'is_hui',
    'type' => 'int(8)',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
  'des' => 
  array (
    'field' => 'des',
    'type' => 'text',
    'null' => 'YES',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
  'aid' => 
  array (
    'field' => 'aid',
    'type' => 'int(8)',
    'null' => 'NO',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
  'del' => 
  array (
    'field' => 'del',
    'type' => 'int(8)',
    'null' => 'NO',
    'key' => false,
    'default' => '0',
    'extra' => '',
  ),
  'rel_ad' => 
  array (
    'field' => 'rel_ad',
    'type' => 'varchar(128)',
    'null' => 'NO',
    'key' => false,
    'default' => '""',
    'extra' => '',
  ),
);
?>