<?php if(user_can('delete_user')):?>
	<?php if(!empty($row)):?>
		<form method="post">
			<div class="row g-3 col-md-6 mx-auto shadow p-4 rounded mt-4">
				<?=csrf()?>
				<h4 class="text-center">Delete Record</h4>
				<div class="alert alert-danger text-center mt-3">  Are you sure you want to delete the Record!?</div>

				<div class="mb-3 col-md-6">
				  <label for="role" class="form-label">Role</label>
				  <div class="form-control"><?=esc($row->role)?></div>
				</div>

				<div class="mb-3 col-md-6">
					<label for="disabled" class="form-label">Active</label>
					<div class="form-control"><?=esc($row->disabled ? "No" : "Yes")?></div>
				</div>

				<div class="d-flex justify-content-between">
					<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>">
						<button type="button" class="btn btn-primary">
							<i class="fa-solid fa-chevron-left"></i> Back
						</button>
					</a>
					<button class="btn btn-danger">
						<i class="fa-solid fa-times"></i> Delete
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