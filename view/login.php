<?php include 'header.php'; ?>

<section>
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-md-6 col-md-offset-3 tab-content">
			  	<div class="tab-pane active">	
				 	<div class="panel panel-default" style="margin-top:50px;">								
					  	<form method="post">						
						  	<?php if(!isset($_SESSION['app-login']) || !$_SESSION['app-login']){ ?>
							  	<div class="panel-body">
							  		
							  		<h3>Login</h3>
									  
									<div class="form-group <?php if(isset($controller->response['formerror'])) echo 'has-error'; ?>">
										<label class="control-label" for="password">App Password: <?php if(isset($controller->response['formerror'])) echo $controller->response['formerror']; ?></label>
								    	<input type="password" class="form-control" id="password" name="password" value="" required>
									</div>
							  	</div>
								<div class="panel-footer">
									<input name="submitLogin" type="submit" value="Login" class="btn btn-large btn-primary"/>
								</div>
							<?php }?>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php include 'footer.php' ?>		
		
				
		
		