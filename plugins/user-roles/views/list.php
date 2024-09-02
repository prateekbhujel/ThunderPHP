<?php if(user_can('view_roles')) :?>
	<form method="post">
		<?=csrf()?>
		<div class="table table-responsive">
			<table class="table table-striped table-bordered">
				<tr>
					<th class="text-center">S.N</th>
					<th class="text-center">Role</th>
					<th class="text-center">Active</th>
					<th>
						<div class="d-flex justify-content-between"> Permssions
							<button class="btn btn-bd-primary btn-sm">
								<i class="fas fa-save mr-2"></i> Save Permissions
							</button>
						</div>
					</th>
					<th>
						<?php if(user_can('add_role')) :?>
							<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/add">
								<button type="button" class="btn btn-bd-primary btn-sm">
									<i class="fas fa-plus me-2"></i> Add new
								</button>
							</a>
						<?php endif; ?>
					</th>
				</tr>
				<?php if(!empty($rows)):?>
					<?php foreach($rows as $row):?>
						<tr>
							<td class="text-center">
								<?=esc($row->id)?>
							</td>
							<td class="text-center">
								<?=esc($row->role)?>
							</td>
							<td class="text-center">
								<?=esc(!$row->disabled ? "Yes" : "No")?>
							</td>
							<td style="max-width: 200px;">
								<div class="row g-2">
									<?php $perms = array_unique(APP('permissions')); ?>
									<?php if (!empty($perms)) :$num=0?>
										<?php foreach($perms as $perm) : $num++?>
											<div class="form-check col-md-6">
											  <input <?= in_array($perm, $row->permissions ?? []) ? ' checked' :  '' ?> name="checkbox_<?=$row->id?>_<?=$num?>" class="form-check-input" type="checkbox" value="<?=$perm?>" id="check-<?=$row->id?>-<?=$num?>">
											  <label class="form-check-label" for="check-<?=$row->id?>-<?=$num?>" style="cursor: pointer;">
											  	<?= esc(ucfirst(str_replace("_", " ", $perm))) ?>
											  </label>
											</div>
										<?php endforeach;?>
									<?php endif;?>
								</div>
							</td>
							<td>
								<?php if(user_can('edit_role')) :?>
									<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/edit/<?=$row->id?>">
										<button type="button" class="btn btn-warning btn-sm">
											<i class="fas fa-pen-to-square me-2"></i>
										</button>
									</a>
								<?php endif;?>

								<?php if(user_can('delete_role')) :?>
									<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/delete/<?=$row->id?>">
										<button type="button" class="btn btn-danger btn-sm">
											<i class="fas fa-trash-can"></i>
										</button>
									</a>
								<?php endif;?>
							</td>
						</tr>
					<?php endforeach;?>
				<?php endif;?>
			</table>
		</div>
	</form>
<?php else :?>
	<div class="alert alert-secondary text-muted text-center m-auto"> 
		Access Denied. You don't have permission for this page, Please Contact System Admin for more information.
	</div>
<?php endif ;?>