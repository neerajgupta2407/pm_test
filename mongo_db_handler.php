<?php
/**
*	Author Neeraj
*	This class file ahandles all the operations needed to interact with  mondo db
*
**/

//include_once('');
//ini_set('display_errors','1');
//echo 'in mongo';
class Mongo_db_handler 
{
	private $database;
	private $collection;
	
	
	function __construct($db_name = 'std')
	{
		
		$this->database = $db_name;

		$this->obj_mongo = $this->get_connection_obj();
		
	}
	/**
	*	Functions: 
	*	1.)Insert
	*	2.)update
	*	3)delete
	*	4.)ftech
	**/
	
	
	
	/**
	*	This function returns the object of mong0  db
	**/
	public function get_connection_obj()
	{
		$m = new MongoClient();
		
		$database = $this->database;
		
		$db = $m->$database;
		//var_dump($db);
		return $db;
	}
	
	/**
	*	This function inserts the  data into mongo db
	*	@Input: collection_name, data_array();
	*	@Output : 
	**/
	
	public function mongo_insert($collection,$data)
	{
		
		//var_dump($obj_mongo);
		//
		$obj_mongo = $this->obj_mongo;
		$m = $obj_mongo->$collection;
		//var_dump($m);
		$response = $m->insert($data);
		
		return $response;
	}
	
	/**
	*	This function fetches the  data
	*	@Input: collection_name, array(
	*					'fields' => array(),
	*					'where' => array(),
	*					'sort'	=> array(),)
	*	@Output : data_array();
	**/
	
	public function mongo_fetch($collection,$data = array(parent))
	{
		
		$response = array();
		$obj_mongo = $this->obj_mongo;

		
		$a = $obj_mongo->$collection;
		
		$fields = is_array($data['fields']) ? $data['fields'] : array();
		$where = is_array($data['where']) ? $data['where'] : array();
		$sort = $data['sort'];
		
		if(count($fields) > 0)
		{
			
			$cursor = $a->find($where, $fields );
		}
		else
		{
			$cursor = $a->find($where );
		}
		//var_dump($data);
		
		if(count($sort)>0)
		{
			$cursor->sort($sort);
		}
		
		foreach ($cursor as $data) 
		{
			$response[] = $data;
		}
		
		return $response;
		
		
	}
	
	/**
	*	This function deletes  the record
	*	@Input: collection_name, delete_condition_array()
	*					
	*	@Output :
	**/
	public function mongo_delete($collection,$data)
	{
		$response = array();
		$obj_mongo = $this->get_connection_obj();
		
		$a = $obj_mongo->$collection;
		
		$response = $a->remove($data);
		//response = {"n":16,"connectionId":2,"err":null,"ok":1}, where n= rows affected
		return $response;
		
	}
	
	/**
	*	This function updates  the record
	*	@Input: collection_name, update_set_array(), where_array()
	*					
	*	
	**/
	
	public function mongo_update($collection,$data,$where)
	{
		$response = array();
		$obj_mongo = $this->get_connection_obj();
		
		$a = $obj_mongo->$collection;
		
		$response =  $a->update(	$where,array('$set' => $data));
		
		// response : {"updatedExisting":true,"n":1,"connectionId":2,"err":null,"ok":1}, n=no of rows affected
		
		return $response;
		
	}
	
	
			
}

/*


$obj = new Mongo_db();

$collection = 'test';
$document = array();
$document['session_id'] =  session_id();
$document['url']['a'] =  $_SERVER['SCRIPT_NAME'];
$document['url']['b'] = 'testing';
$document['query_string'] =  $_SERVER['QUERY_STRING'];
$document['added_date'] =  date('Y-m-d H:i:s',time());
$document['epoctime'] =  time();


$obj->mongo_insert($collection,$document);
//$obj->mongo_fetch($collection,array());
//exit;

$where = array('url.b' => 'testing');
$sort = array('epoctime' => -1);

$data = array();
//$data['fields'] = array('url' => 1);
//$data['where'] = $where;
$data['sort'] = $sort;
//echo json_encode($obj->mongo_fetch($collection,$data));






$data = array('customfield' => '123');
$where = array('url.b' => 'testing'); 
echo json_encode( $obj->mongo_update($collection,$data,$where));

exit;
//echo json_encode( $obj->mongo_delete($collection,$where));



/*
$m = new MongoClient();
$db = $m->dineout;
echo "<br>";




$collection = $db->$collection;
//$collection->insert($document);



$collection1 = $db->test;

var_dump($collection1);
// find everything in the collection
$cursor = $collection1->find();

/*
// iterate through the results
foreach ($cursor as $document) 
{
    echo $document["session_id"].' '.$document['url'].' '.$document['added_date']. "<br>";
}
*/
?>
