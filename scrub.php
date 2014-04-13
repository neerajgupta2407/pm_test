<?php

ini_set('display_errors', '1');
include('mongo_db_handler.php');
include('url_config.php');
include 'Simple_html_dom.php';


$obj_mongo = new Mongo_db_handler();

$data = $obj_mongo->mongo_fetch('meta');
//var_dump($data);

$i=0;
foreach($data as $val)
{
	echo "<br>i is ".$i++;
	//$dom = new simple_html_dom();
	$dom = str_get_html($val['meta']);
	
	$anchor = $dom->find('a');
	
	//$tag='h1[itemprop=name]';
	$tag = 'span[id=qa-prd-brand]';
	
	$res = $dom->find($tag,0);
	
	if(is_null($res) )
	{
		//|| (is_array($res) && count($res) == 0)
		echo "res is empty.Hence continue..\n\n\n";
		
		//dom clear need to be called every time in order to free up the memory...other wise it will eat up all the memory..
		$dom->clear();
		continue;
	}
	else
	{
		echo "in else..\n\n";
		echo $res;
	}
	
	echo "\n\n\n\n";
	
	$dom->clear();
	//exit;
	//var_dump($anchor);
}

