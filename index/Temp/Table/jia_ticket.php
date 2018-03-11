<?php if(!defined('HDPHP_PATH'))exit;
return array (
  'tid' => 
  array (
    'field' => 'tid',
    'type' => 'int(8)',
    'null' => 'NO',
    'key' => true,
    'default' => NULL,
    'extra' => 'auto_increment',
  ),
  'tname' => 
  array (
    'field' => 'tname',
    'type' => 'varchar(32)',
    'null' => 'NO',
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
  'rel_ad' => 
  array (
    'field' => 'rel_ad',
    'type' => 'varchar(128)',
    'null' => 'NO',
    'key' => false,
    'default' => '""',
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
  'time' => 
  array (
    'field' => 'time',
    'type' => 'int(16)',
    'null' => 'NO',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
  'price' => 
  array (
    'field' => 'price',
    'type' => 'int(8)',
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
  'del' => 
  array (
    'field' => 'del',
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
    'null' => 'NO',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
  'descri' => 
  array (
    'field' => 'descri',
    'type' => 'varchar(32)',
    'null' => 'NO',
    'key' => false,
    'default' => '""',
    'extra' => '',
  ),
  'man' => 
  array (
    'field' => 'man',
    'type' => 'varchar(16)',
    'null' => 'NO',
    'key' => false,
    'default' => '99.6%',
    'extra' => '',
  ),
  'worktime' => 
  array (
    'field' => 'worktime',
    'type' => 'varchar(32)',
    'null' => 'NO',
    'key' => false,
    'default' => '""',
    'extra' => '',
  ),
  'notice' => 
  array (
    'field' => 'notice',
    'type' => 'text',
    'null' => 'NO',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
  't1' => 
  array (
    'field' => 't1',
    'type' => 'text',
    'null' => 'NO',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
  't2' => 
  array (
    'field' => 't2',
    'type' => 'text',
    'null' => 'NO',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
  't3' => 
  array (
    'field' => 't3',
    'type' => 'text',
    'null' => 'NO',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
  'valid' => 
  array (
    'field' => 'valid',
    'type' => 'varchar(64)',
    'null' => 'NO',
    'key' => false,
    'default' => '一天',
    'extra' => '',
  ),
);
?>