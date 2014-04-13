<?php
ini_set('display_errors', '1');	
include('mongo_db_handler.php');
include('url_config.php');



function get_meta($url)
{
	$data = file_get_contents($url);
	return $data;
}


$obj_mongo = new Mongo_db_handler();
$collection = "meta";

//var_dump($config_url);
foreach($config_url as $val)
{
	$meta = get_meta($val['url']);

	$mongo_data = array();
	$mongo_data['site'] = $val['site'];
	$mongo_data['cat'] = $val['cat'];
	$mongo_data['url'] = $val['url'];
	$mongo_data['meta'] = $meta;
	$mongo_data['dt'] = date('Y-m-d H:i:s');

	$res = $obj_mongo->mongo_insert($collection,$mongo_data);

	var_dump($res);

}