<?php
	/* INCLUDE CONFIG */
	include_once('config.php');
	
	/* PHP SESSION */
	session_id();
	session_start();	
	
	if(!isset($_REQUEST['action']))
		$_REQUEST['action'] = "";
		
	if($_REQUEST['action'] != 'login' && (!isset($_SESSION['app-login']) || !$_SESSION['app-login'])){ 
	    header("Location: ./login");
	}
	
	/* INCLUDE ALL CONTROLLERS */
	foreach (glob("controllers/*.php") as $filename)
	{
	    include_once($filename);
	}
	
	/* SETUP LIMITED ROUTES */
	$controller = new AppController();
	$_REQUEST['selectednav'] = "";
	if($_REQUEST['action'] == '' || $_REQUEST['action'] == 'list_sales'){
		$_REQUEST['selectednav'] = "list_sales";
		$controller->listLabels('sales');
	}elseif($_REQUEST['action'] == 'add_sales'){
		$_REQUEST['selectednav'] = "list_sales";
		$controller->editLabel('sales');
	}elseif($_REQUEST['action'] == 'edit_sales'){
		$_REQUEST['selectednav'] = "list_sales";
		$controller->editLabel('sales');
	}elseif($_REQUEST['action'] == 'delete_sales'){
		$_REQUEST['selectednav'] = "list_sales";
		$controller->deleteLabel('sales');

	}elseif($_REQUEST['action'] == 'list_ws'){
		$_REQUEST['selectednav'] = "list_ws";
		$controller->listLabels('ws');
	}elseif($_REQUEST['action'] == 'add_ws'){
		$_REQUEST['selectednav'] = "list_ws";
		$controller->editLabel('ws');
	}elseif($_REQUEST['action'] == 'edit_ws'){
		$_REQUEST['selectednav'] = "list_ws";
		$controller->editLabel('ws');
	}elseif($_REQUEST['action'] == 'delete_ws'){
		$_REQUEST['selectednav'] = "list_ws";
		$controller->deleteLabel('ws');

	}elseif($_REQUEST['action'] == 'list_bec'){
		$_REQUEST['selectednav'] = "list_bec";
		$controller->listLabels('bec');
	}elseif($_REQUEST['action'] == 'add_bec'){
		$_REQUEST['selectednav'] = "list_bec";
		$controller->editLabel('bec');
	}elseif($_REQUEST['action'] == 'edit_bec'){
		$_REQUEST['selectednav'] = "list_bec";
		$controller->editLabel('bec');
	}elseif($_REQUEST['action'] == 'delete_bec'){
		$_REQUEST['selectednav'] = "list_bec";
		$controller->deleteLabel('bec');
	
	}elseif($_REQUEST['action'] == 'list_hello'){
		$_REQUEST['selectednav'] = "list_hello";
		$controller->listLabels('hello');
	}elseif($_REQUEST['action'] == 'add_hello'){
		$_REQUEST['selectednav'] = "list_hello";
		$controller->editLabel('hello');
	}elseif($_REQUEST['action'] == 'edit_hello'){
		$_REQUEST['selectednav'] = "list_hello";
		$controller->editLabel('hello');
	}elseif($_REQUEST['action'] == 'delete_hello'){
		$_REQUEST['selectednav'] = "list_hello";
		$controller->deleteLabel('hello');

	}elseif($_REQUEST['action'] == 'login'){
		$_REQUEST['selectednav'] = "login";
		$controller->login();

	}else{
		$controller->errorInvalidPage();
	}

	/* INCLUDE VIEW FILE */
	include ".".$controller->getViewFile();

?>