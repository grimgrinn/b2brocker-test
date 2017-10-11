<?php
define('ROOT', dirname(__FILE__));
require_once(ROOT.'/components/Autoload.php');
var_dump($_POST);

if(isset($_POST['id'])){
	$response = (new Responder())
		->receive($_POST)
		->response();
}