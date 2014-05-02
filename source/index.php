<?php
//use Slim\Slim;
//Login to AD passing some value

/*



$test=new ADConnect();*/

//include the slim class file
require '../libs/Slim/Slim.php';
include 'ADConnect.php';

//Register AutoLoader
\Slim\Slim::registerAutoloader();

//create class instance
//initialise application
$app= new \Slim\Slim(array(
		'log.enable'=>true,
		'log.path'=>'./logs',
		'log.level'=>4,
		'debug'=>true
		));


//Set application name
$app->setName("ADConnect");

$app->get('/user/:gslab_id',function ($gslab_id){
	//This method help to search fields
	
	$test=new ADConnect();
	$result=$test->getUser($gslab_id);
	echo json_encode($result);
	//if($result)
	//echo json_encode($result);
});

//Process the Get method to get project practice
$app->get('/search/:field/:name',function ($field,$name){
	//This method help to search fields
	
	
	echo "Hello there";
});

$app->response->headers->set('Content-Type','application/json');


//Process the post methods
	$app->post('/autheticate',function () use ($app){
		//print_r($app->request->post());
		try {
		$test=new ADConnect();
		$attr=$app->request->post("attr");
		$uname=$app->request->post("username");
		$password=$app->request->post("password");		
		$app->contentType('application/json');
	    
		if($test->checkLogin($attr,$uname,$password))			
		{
			
			$app->response()->setStatus(200);
			$app->response()->setBody(json_encode('SUCCESS'));
	
		}
		else
		{
			$app->response()->setStatus(401);
			$app->response()->setBody(json_encode('Unauthorized'));
			
		}
		}
		catch(Exception $e)
		{
			echo "Authentication Failed".$e;
		}
		
		
	});
	

//Process the get method to serch data from LDAP

	


$app->run();