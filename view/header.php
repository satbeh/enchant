<!DOCTYPE html>
<html>
	<head>
		<title>Enchant Labels App</title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"  media="screen">
		<link rel="stylesheet" href="//cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css"  media="screen">
		<link rel="stylesheet" href="<?php echo APPURL; ?>assets/css/admin.css">
		
		<script src="//code.jquery.com/jquery-1.12.3.js"></script>
		<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
		<script src="//cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
	</head>
	<body>
		<header>
			<div class="container">
				<div class="title">Labels Manager</div>
				<div style="float:right;">
				<?php if(isset($_SESSION['app-login']) && $_SESSION['app-login']){ ?>
		  			<form method="post" action="<?php echo APPURL; ?>login">
						<input name="submitLogout" type="submit" value="Logout" class="btn btn-large btn-primary"/>
					</form>
				<?php }?>
				</div>
			</div>
		</header>
