<?php
require_once 'libs/route.php';
require_once 'app/controllers/controller.php';

$router = new Router();


$router->addRoute('invocacion','GET','controller','getAll');
$router->addRoute('invocacion/:ID', 'GET', 'controller', 'getInvById');
$router->addRoute('invocacion/:ID','DELETE','controller','delete');
$router->addRoute('invocacion','POST','controller','addInv');
$router->addRoute('invocacion/:ID','PUT','controller','updateInv');


$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);