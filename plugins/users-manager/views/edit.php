<?php if(!empty($row)):?>

	<form method="post" enctype="multipart/form-data">
		
		<div class="row g-3 col-md-6 mx-auto shadow p-4 rounded mt-4">
				
			<?=csrf()?>
			
			<h4 class="">Edit Record</h4>
			
			<label class="text-center">
				<img src="<?=get_image($row->image)?>" class="img-thumbnail" style="cursor:pointer; width:100%;max-width:200px;max-height: 200px;object-fit: cover;">
				<input type="file" name="image" class="d-none">
			</label>

			<div class="mb-3 col-md-6">
			  <label for="first_name" class="form-label">First Name</label>
			  <input name="first_name" value="<?=old_value('first_name',$row->first_name)?>" type="text" class="form-control" id="first_name" placeholder="First Name">
			  
			  <?php if(!empty($errors['first_name'])) :?>
			  	<small class="text-danger"><?=$errors['first_name']?></small>
			  <?php endif;?>

			</div>

			<div class="mb-3 col-md-6">
			  <label for="last_name" class="form-label">Last Name</label>
			  <input name="last_name" value="<?=old_value('last_name',$row->last_name)?>" type="text" class="form-control" id="last_name" placeholder="Last Name">			  

			  <?php if(!empty($errors['last_name'])) :?>
			  	<small class="text-danger"><?=$errors['last_name']?></small>
			  <?php endif;?>

			</div>

			<div class="mb-3 col-md-6">
			  <label for="email" class="form-label">Email</label>
			  <input name="email" value="<?=old_value('email',$row->email)?>" type="email" class="form-control" id="email" placeholder="Email Address">			  

			  <?php if(!empty($errors['email'])) :?>
			  	<small class="text-danger"><?=$errors['email']?></small>
			  <?php endif;?>

			</div>

			<div class="mb-3 col-md-6">
				<label for="gender" class="form-label">Gender</label>
				<select  value="" class="form-select" name="gender">
				  <option selected>--Select Gender--</option>
				  <option <?=old_select('gender','male',$row->gender)?> value="male">Male</option>
				  <option <?=old_select('gender','female',$row->gender)?> value="female">Female</option>
				</select>
				
				<?php if(!empty($errors['gender'])) :?>
			  		<small class="text-danger"><?=$errors['gender']?></small>
			  	<?php endif;?>

			</div>

			 <small class="text-muted">(Leave password empty to keep the old one)</small>
			<div class="mb-3 col-md-6">
			  <label for="password" class="form-label">Password</label>
			  <input name="password" value="<?=old_value('password','')?>" type="text" class="form-control" id="password" placeholder="Password">

			  <?php if(!empty($errors['password'])) :?>
			  	<small class="text-danger"><?=$errors['password']?></small>
			  <?php endif;?>

			</div>

			<div class="mb-3 col-md-6">
			  <label for="retype_password" class="form-label">Retype Password</label>
			  <input name="retype_password" type="text" class="form-control" id="retype_password" placeholder="Retype password">
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