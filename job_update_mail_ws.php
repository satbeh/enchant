<?php
header("Access-Control-Allow-Origin: *");
//header('Content-Type: application/json');

include("config.php");
include("./controllers/AppController.php");

$controller = new AppController();
$controller->updateMails('ws');
?>