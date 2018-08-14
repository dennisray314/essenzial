<?php
if(class_exists("WP_REST_Request")){
	//The request class was found, move on
	include_once "wplc-api-routes.php";
	include_once "wplc-api-functions.php";
}else{
	//No Rest Request class
}
