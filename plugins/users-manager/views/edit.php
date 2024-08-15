<?php if(!empty($row)):?>

	<div class="row g-3 col-md-6 mx-auto shadow p-4 rounded">
		<h4 class="">Edit Record</h4>
		
		<div class="text-center">
			<img src="<?=get_image($row->image)?>" class="img-thumbnail" style="width:100%;max-width:200px;max-height: 200px;object-fit: cover;">
		</div>

		<div class="mb-3 col-md-6">
		  <label for="first_name" class="form-label">First Name</label>
		  <input name="first_name" value="<?=old_value('first_name',$row->first_name)?>" type="text" class="form-control" id="first_name" placeholder="First Name">
		</div>

		<div class="mb-3 col-md-6">
		  <label for="last_name" class="form-label">Last Name</label>
		  <input name="last_name" value="<?=old_value('last_name',$row->last_name)?>" type="text" class="form-control" id="last_name" placeholder="Last Name">
		</div>

		<select class="form-select" name="gender">
		  <option selected>--Select Gender--</option>
		  <option <?=old_select('gender','male',$row->gender)?> value="male">Male</option>
		  <option <?=old_select('gender','female',$row->gender)?> value="female">Female</option>
		</select>

		 <small class="text-danger">(Leave password empty to keep the old one)</small>
		<div class="mb-3 col-md-6">
		  <label for="password" class="form-label">Password</label>
		  <input name="password" value="<?=old_value('password','')?>" type="text" class="form-control" id="password" placeholder="Password">
		</div>

		<div class="mb-3 col-md-6">
		  <label for="retype_password" class="form-label">Retype Password</label>
		  <input name="retype_password" type="text" class="form-control" id="retype_password" placeholder="Retype password">
		</div>
		
		<div class="d-flex justify-content-between">
			<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>">
				<button class="btn btn-primary">
					<i class="fa-solid fa-chevron-left"></i> Back
				</button>
			</a>
			<button class="btn btn-danger">
				<i class="fa-solid fa-save"></i> Save
			</button>
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