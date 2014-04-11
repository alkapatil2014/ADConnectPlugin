<?php
//use Slim\Slim;
//Login to AD passing some value

/*



$test=new ADConnect();*/
//$test->checkLogin("uid","GS-0359","Pass@word123");
//$test->search("(cn=alka*)");
//echo $test.
//echo $test;
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

//Process the Get method
$app->get('/eat/:food',function ($food){
	echo "Hello there";
});
	$app->response->headers->set('Content-Type','application/json');


//Process the post methods
	$app->post('/autheticate',function () use ($app){
		//print_r($app->request->post());
		$test=new ADConnect();
		$attr=$app->request->post("attr");
		$uname=$app->request->post("username");
		$password=$app->request->post("password");		
	//	$app->response->headers->set('Content-Type','application/json');
		if($test->checkLogin($attr,$uname,$password))			
		{
			$app->response()->setStatus(200);
		//	$success='SUCCESS';
		}
		else
		{
			echo "Error";
			//$app->response()->setStatus(402);
		//	$success='ERROR';
		}
	//	echo $success;
			
		
	});
	




$app->run();