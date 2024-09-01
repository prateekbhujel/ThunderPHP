<?php if(user_can('edit_user')) :?>

	<?php if(!empty($row)):?>

		<form onsubmit="submit_form(event)" method="post">
			
			<div class="row g-3 col-md-6 mx-auto shadow p-4 rounded mt-4">
				<?=csrf()?>
				<h4 class="text-center">Edit Record</h4>

				<div class="mb-3 col-md-6">
				  <label for="role" class="form-label">Role</label>
				  <input name="role" value="<?=old_value('role', $row->role)?>" type="text" class="form-control" id="role" placeholder="Role Name">
				  
				  <?php if(!empty($errors['role'])) :?>
				  	<small class="text-danger"><?=$errors['role']?></small>
				  <?php endif;?>
				</div>

				<div class="mb-3 col-md-6">
					<label for="disabled" class="form-label">Active</label>
					<select  value="" class="form-select" name="disabled">
					  <option selected>--Select Status--</option>
					  <option <?=old_select('disabled', '0', $row->disabled)?> value="0">Yes</option>
					  <option <?=old_select('disabled', '1', $row->disabled)?> value="1">No</option>
					</select>
				</div>

				<div class="d-flex justify-content-between">
					<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>">
						<button type="button" class="btn btn-primary">
							<i class="fa-solid fa-chevron-left"></i> Back
						</button>
					</a>
					<button class="btn btn-danger">
						<i class="fa-solid fa-save"></i> Save
					</button>
				</div>
			</div>
		</form>

	<?php else:?>
		<div class="alert alert-danger text-center">
			That record was not found!
		</div>
		<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>">
			<button class="btn btn-primary">Back</button>
		</a>
	<?php endif?>

<?php else :?>
	<div class="alert alert-secondary text-muted text-center m-auto"> 
		Access Denied. You don't have permission for this page, Please Contact System Admin for more information.
	</div>

<?php endif ;?>