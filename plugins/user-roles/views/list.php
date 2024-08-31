<?php if(user_can('view_users')) :?>

	<div class="table table-responsive">
		<table class="table table-striped table-bordered">
			<tr>
				<th class="text-center">S.N</th>
				<th class="text-center">Role</th>
				<th class="text-center">Active</th>
				<th class="text-center">Permssions</th>
				<th>
					<?php if(user_can('add_user')) :?>
						<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/add">
							<button class="btn btn-bd-primary btn-sm">
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
						<td>
							<?=esc($row->role)?>
						</td>
						<td class="text-center">
							<?=esc(!$row->disabled ? "Yes" : "No")?>
						</td>
						<td class="text-center">
							<?php dd(array_unique(APP('permissions'))); ?>
						</td>
						<td>
							<?php if(user_can('edit_role')) :?>
								<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/edit/<?=$row->id?>">
									<button class="btn btn-warning btn-sm">
										<i class="fas fa-pen-to-square me-2"></i>
									</button>
								</a>
							<?php endif;?>

							<?php if(user_can('delete_role')) :?>
								<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/delete/<?=$row->id?>">
									<button class="btn btn-danger btn-sm">
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
<?php else :?>
	<div class="alert alert-secondary text-muted text-center m-auto"> 
		Access Denied. You don't have permission for this page, Please Contact System Admin for more information.
	</div>
<?php endif ;?>