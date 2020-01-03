<?php
if($popup!="Y")
{
	?>
 <!-- Modal -->
  <div class="modal fade" id="configModal" role="dialog">
	  <form method="POST" action="<?php echo $update_config_url ?>" >
	  <input type="hidden" name="mode" id="mode" value="U">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
		  <div class="modal-content">
			
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title"><label>Change Settings</label></h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>New Password:</label>
					<input type="password" name="pass1" >
				</div>
			</div>
			<div class="modal-footer">
			  <input type="submit" id="update-config" class="btn btn-default" value="Update Settings">
			</div>
			
		  </div>
		  
		</div>
	  </form>
  </div>
  <!-- Modal End -->
   
  
		<script>
		
		</script>
		<?php
}
?>