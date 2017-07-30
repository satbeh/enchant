<?php include 'header.php'; ?>
<script>
$(document).ready(function() {
    $('#table_labels').DataTable();
} );
</script>
<section>
	<div class="container">
		<div class="row">
			<div class="hidden-xs hidden-sm col-md-2">						
				<?php include 'nav.php' ?>
			</div>
			<div class="col-xs-12 col-md-10 tab-content">
				
			  	<div class="tab-pane active" id="chooseProducts">	
				 	<div class="panel panel-default">								
					  	<div class="panel-body">
					  		<br>							
						    <table id="table_labels" class="table table-striped table-bordered" cellspacing="0" width="100%">
						      <thead>
						        <tr>
						          <th>Label ID (click link to edit duration)</th>
						          <th>Reopen Duration</th>
						          <th>View / Edit Label in Enchant</th>
											<th>Remove Label</th>
						        </tr>
						      </thead>
						      <tbody>
						       <?php
						       	if (count($controller->response['labels']) > 0) {
								    // output data of each row
								    foreach($controller->response['labels'] as $key => $value) {
								    	?>
								        <tr>
								          <td><a href="<?php echo APPURL."edit_".$controller->response['type']."?id=".$key;?>"><?php echo $key;?></a></td>
									      	<td><?php echo $value;?></td>
									      	<td><a href="<?php echo ENCHANT_URL."settings/inboxes/".$controller->response['inbox']."/labels/".$key; ?>">view / edit label in enchant</a></td>
								          <td><a href="<?php echo APPURL."delete_".$controller->response['type']."?id=".$key;?>">remove</a></td>
								        </tr><?php
								    }
						       	}else{?>
						       		<tr>
						       			<td colspan="6">No label codes found.</td>
						       		</tr>
						       		<?php
						       	}
						       ?>
						        
						      </tbody>
						    </table>
					  	</div>
					  	<div class="panel-footer"><button class="btn btn-large btn-primary" onclick="location.href='<?php echo APPURL."add_".$controller->response['type']; ?>';">Add New</button></div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</section>
		
<?php include 'footer.php' ?>		
		
		