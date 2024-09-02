<?php if(user_can('view_role_details')):?>

	<?php if(!empty($row)):?>
		<div class="row g-3 col-md-6 mx-auto shadow p-4 rounded mt-4">
			<h4 class="text-center">View Record</h4>

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
					<button class="btn btn-primary">
						<i class="fa-solid fa-chevron-left"></i>
					</button>
				</a>

				<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/edit/<?=$row->id?>">
					<button class="btn btn-warning">
						<i class="fa-solid fa-pen-to-square"></i>
					</button>
				</a>

				<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/delete/<?=$row->id?>">
					<button class="btn btn-danger">
						<i class="fa-solid fa-times"></i>
					</button>
				</a>

			</div>

		</div>

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