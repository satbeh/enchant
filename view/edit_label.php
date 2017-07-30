<?php 
	include 'header.php'; 
	$label = $controller->response['label'];
?>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
<section>
	<div class="container">
		<div class="row">
			<div class="hidden-xs hidden-sm col-md-2 col-lg-2">						
				<?php include 'nav.php' ?>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
				<form role="form" method="post" >
				  	<div class="tab-pane active" id="chooseProducts">							
					 	<div class="panel panel-default">								
						  	<div class="panel-body">
						  		<?php 
						  			if($label['id'] == "") 
						  				echo "<h3>Add Label to Reopen</h3>";
						  			else
						  				echo "<h3>Edit Label Reopen Duration ( #" . $label['id'] . " )</h3>";
						  		?>
								<?php if($label['id'] == "") { ?>
									<div class="form-group">
							    		<label for="id">Enchant Label ID:</label>
							    		<input type="text" class="form-control" id="id" name="id" value="<?php echo $label['id']; ?>" required>
							  		</div>
								<?php } else {?>
						  			<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $label['id']; ?>">
						  		<?php } ?>
							  	<div class="form-group">
							    	<label for="label_duration">Duration( no of days) :</label>
							    	<input type="number" min="1" class="form-control" id="label_duration" name="label_duration" value="<?php echo $label['duration']; ?>" required>
							  	</div>
						  	</div>
							<div class="panel-footer">
								<input type="submit" class="btn btn-large btn-primary" value=" Save " name="save_label">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
    $(function () {
        $('#start_date').datetimepicker();
        $('#end_date').datetimepicker();
    });
</script>
<?php include 'footer.php' ?>		
		
		