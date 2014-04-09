<?php
//Login to AD passing some value
include 'ADConnect.php';



$test=new ADConnect();
//$test->checkLogin("uid","GS-0359","Pass@word123");
$test->search("(cn=alka*)");
//echo $test.
//echo $test;