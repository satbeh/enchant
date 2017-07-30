<?php
header("Access-Control-Allow-Origin: *");
//header('Content-Type: application/json');

ini_set('max_execution_time', 300);

include("config.php");
include("./controllers/AppController.php");

$controller = new AppController();
$controller->updateMails($_GET["inbox"]);
?>