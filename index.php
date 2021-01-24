<?php 	

header('Acces-Control-Allow-Origin: *');
header("Acces-Control-Allow-Headers: Origin, X-Requested-With, Content-Type,Accept");
header('Acces-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=utf-8');

require_once "controlador/route.controller.php";

require_once "controlador/get.controller.php";
require_once "modelo/get.model.php";

require_once "controlador/post.controller.php";
require_once "modelo/post.model.php";

require_once "controlador/put.controller.php";
require_once "modelo/put.model.php";

require_once "controlador/delete.controller.php";
require_once "modelo/delete.model.php"; 

require_once "vendor/autoload.php";

$index = new RoutesController();

$index -> index();
 