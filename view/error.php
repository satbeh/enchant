<?php include 'header.php' ?>

<section>
	<div class="container">
		<div class="row">
			<div class="hidden-xs hidden-sm col-md-2 col-lg-2">						
				<?php include 'nav.php' ?>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 tab-content">
				
			  	<div class="tab-pane active"							
				 	<div class="panel">								
					  	<div class="panel-body">
							<h3>Error</h3>
							<blockquote>
								<p><?php echo $controller->response['errorMessage']; ?></p>
							</blockquote>							
					  	</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</section>
		
<?php include 'footer.php' ?>		
		
		